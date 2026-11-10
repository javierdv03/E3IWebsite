<?php
namespace App\Models\JWT;

use ErrorException;
use Exception;

require_once dirname(__DIR__) ."/../../vendor/autoload.php";
require_once dirname(__DIR__) . "/../GlobalFiles/Constants.php";


use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

/**
 * Summary of JWTModel
 * 
 * Implements JWT functions that generally talking,
 * are made to make reCAPTCHA expirable & verifiable
 * based tokens!
 * 
 * It also is based in Singleton creator pattern
 * @package JWTModel
 * 
 */
class JWTModel
{
    private array $payload;
    private string $generatedToken = "";
    private Key $privateKey;

    private static ?JWTModel $instance = null;

    public function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(BASE_PATH);
        $dotenv->load();
        $this->setPrivateKey(new Key($_ENV["JWTPASS"], $_ENV["JWTALG"]));
    }

    
    /**
     * Summary of checkJWTTokenValidity
     * 
     * Checks if a JWT token is valid or not
     * by reviewing if it's expired or just invalid.
     * Also it's duplicated protected, by checking if 
     * JTI already exists in the database.
     * 
     * @throws \Exception if token is not generated
     * @throws ExpiredException if token has expired
     * @throws SignatureInvalidException if token is invalid
     * @return bool if it's valid or not
     */
    public function checkJWTTokenValidity(String $token) : bool
    {
        try
        {
            if(!$token) return false;
            JWT::decode($token, $this->getPrivateKey());

        }catch(Exception $generalException)
        {
            return false;
        }

        return true;
              
    }


    public function setPayload(array $context): void 
    {   
        $customTimeExp = time() + ($context["MAILEXPIRATION"] ?? $_ENV["JWTEXPIRETIME"]);
        unset($context["MAILEXPIRATION"]);
        
        $this->payload = array_merge([ "iss" => $_ENV["JWTISS"],  "iat" => time(), "exp" =>  $customTimeExp ], $context);
    }


    public function setToken(): void
    {
        if(!$this->getPayload()) throw new Exception("Payload isn't even instancied lil boy");

        $this->generatedToken = JWT::encode($this->getPayload(), $_ENV["JWTPASS"], $_ENV["JWTALG"]);
    }

    public function getEntity(String $token, String $key) : String
    {
        $content = "";

        try
        {
            $decodedToken = JWT::decode($token, $this->getPrivateKey());

            if(!property_exists($decodedToken, $key)) throw new ErrorException("The key have not been found " + $key);

            $content = $decodedToken->$key;

        } catch(Exception $e)
        {
            die(var_dump($e));
        }   
        
        return $content;
        

    }




    
    /**
     * Summary of setPrivateKey
     * 
     * Sets the private key to create and verify
     * tokens.
     * 
     * @param \Firebase\JWT\Key $pKey private key
     * @return void
     */
    public function setPrivateKey(Key $pKey)
    {
        $this->privateKey = $pKey;
    }

    /**
     * Summary of getGeneratedToken
     * 
     * Getter of token attribute.
     * @return string token
     */
    public function getGeneratedToken() : string
    {
        if(!$this->generatedToken) $this->setToken();

        return $this->generatedToken;
    }
    
    /**
     * Summary of getPayload
     * 
     * Getter of payload attribute
     * @return array payload attribute
     */
    public function getPayload() : array
    {
        return $this->payload;
    }

    /**
     * Summary of getPrivateKey
     * 
     * Getter of private key Attribute
     * @return Key  private key Attribute
     */
    public function getPrivateKey() : Key
    {
        return $this->privateKey;
    }

    /**
     * Summary of __tostring
     * 
     * As a way to debug, it returns a string
     * of the payload and jwt generated.
     * @return string payload & jwt generated
     */
    public function __tostring() : string
    {
        $this->getPayload()["jwtGenerated"] = $this->getGeneratedToken();

        $result = "";

        foreach ($this->getPayload() as $key => $value)  $result .= $key . "-> " . $value . "\n";

        return $result;
    }


    private function __clone(): void {}
    public function __wakeup(): void
    {
        throw new Exception("Cannot unserialize singleton");
    }

     /**
      * Summary of getInstance
      *
      * Getter of JWTModel Singleton Instance.
      * 
      * @return JWTModel|null JWTModel singleton
      */
     public static function getInstance(): JWTModel
    {
        if (self::$instance === null) self::$instance = new JWTModel();
                
        return self::$instance;
    }


}