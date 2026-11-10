<?php
namespace App\Controllers\Auth;
session_start();

require_once dirname(__DIR__) . "/../Models/Auth/AuthModel.php";
require_once dirname(__DIR__) . "/../reCAPTCHA/reCaptchaClass.php";
require_once dirname(__DIR__) . "/../Models/JWT/JWTModel.php";
require_once dirname(__DIR__) . "/../Models/Auth/AuthenticatorModel.php";
require_once dirname(__DIR__) . "/../Models/EmailVerification/EmailVerificationModel.php";
require_once dirname(__DIR__) . "/../Utils.php";


use App\Models\Auth\AuthModel;
use App\Models\JWT\JWTModel;
use App\Models\Auth\Authenticator\AuthenticatorModel;
use App\Models\EmailVerification\EmailVerificationModel;
use reCaptchaClass;

class AuthController
{
    private AuthModel $authMe;
    private JWTModel $jwtToken;

    private AuthenticatorModel $authenticator;

    private EmailVerificationModel $mailSender;


    public function __construct()
    {
        $this->authMe = new AuthModel();
        $this->jwtToken = new JWTModel();
        $this->authenticator = new AuthenticatorModel();
        $this->mailSender = new EmailVerificationModel();
    }

    public function register(array $request) : array
    {
        $reCaptchaCheck = new reCaptchaClass($request["g-recaptcha-response"]);

        if(!$reCaptchaCheck->isAllowed()) return ["httpCode" => 401, "content" => "El captcha no es válido"]; 

        if(!validarDniNie($request["NIF"])) return ["httpCode" => 400, "content" => "El documento introducido no es válido."];

        $emailCheckExistence = $this->authMe->emailExist($request["email"]);
        $nifCheckExistence = $this->authMe->NifExist($request["NIF"]);

        if($emailCheckExistence || $nifCheckExistence) return ["httpCode" => 409, "content" => "Algo no nos cuadra..."];

        $this->authMe->registerUser($request["NIF"], $request["name"], $request["surname"],$request["email"], $request["password"], $request["phone"]);

        $qrCode = $this->authenticator->set2FA($request["NIF"]);

        if(!$qrCode) return ["httpCode" => 400, "content" => "Error en la generación del 2FA"];

        $_SESSION['NIF'] = $request["NIF"];
        $_SESSION['Email'] = $request["email"];
        $_SESSION['Name'] = $request["name"] . " " . $request["surname"];

        $this->jwtToken->setPayload(["aud" => "/Auth/Verify2FA", "context" => "2FA"]);
        
        $this->mailSender->sendANewMail($request["NIF"], $request["email"]);

        return ["httpCode" => 201, "content" =>["qrCode" => $qrCode, "X-Authenticator" => $this->jwtToken->getGeneratedToken()]];
    }

    public function login(array $request) : array
    {
        $reCaptchaCheck = new reCaptchaClass($request["g-recaptcha-response"]);

        if(!$reCaptchaCheck->isAllowed()) return ["httpCode" => 401, "content" => "El captcha no es válido"]; 

        $emailCheckExistence = $this->authMe->emailExist($request["email"]);

        if(!$emailCheckExistence) return ["httpCode" => 401, "content" => "Combinación de credenciales no válida."];

        $isValid = $this->authMe->loginUser($request["email"], $request["password"]);

        if(!$isValid) return ["httpCode" => 401, "content" => "Combinación de credenciales no válida."];

        $NIF = $this->authMe->getNIF($request["email"]);

        $_SESSION["NIF"] = $NIF;
        $_SESSION['Email'] = $request["email"];
        $_SESSION['Name'] = $this->authMe->getName($request["email"]);

        $this->jwtToken->setPayload(["aud" => "/Auth/Verify2FA", "context" => "2FA"]);

        return ["httpCode" => 200, "content" => $this->jwtToken->getGeneratedToken()];
    } 
    
    public function AuthenticatorVerify(array $request) : array
    {
        $reCaptchaCheck = new reCaptchaClass($request["g-recaptcha-response"]);

        if(!$reCaptchaCheck->isAllowed()) return ["httpCode" => 401, "content" => "El captcha no es válido"]; 

        if(!isset($_SESSION['NIF'])) return ["httpCode" => 400, "content" => "Algo ha salido mal"];

        $NIF = $_SESSION["NIF"];

        $isAllowed = $this->authenticator->verifyCode($request["2FA"], $NIF);

        if(!$isAllowed) return ["httpCode" => 401, "content" => "Código inválido"];

        $isVerifiedMail = $this->mailSender->checkIfVerified($_SESSION["NIF"]);

        if(!$isVerifiedMail) return ["httpCode" => 301, "content" => "Email no verificado"];

        $isAdmin = $this->authMe->isAdmin($NIF);
        
        $_SESSION['Val'] = $isAdmin ? "admin" : "user";

        $this->jwtToken->setPayload(["context" => $isAdmin ? "admin" : "user", "id" => $NIF]);

        return ["httpCode" => 200, "content" => $this->jwtToken->getGeneratedToken()];
    }
}
