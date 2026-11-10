<?php
namespace App\Models\EmailVerification;

require_once dirname(__DIR__) . "/../../vendor/autoload.php";
require_once dirname(__DIR__) . "/Database/DatabaseModel.php";
require_once dirname(__DIR__) . "/JWT/JWTModel.php";
require_once dirname(__DIR__) . "/../Models/Auth/AuthModel.php";

use App\Models\Database\DatabaseModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\JWT\JWTModel;
use App\Models\Auth\AuthModel;

class EmailVerificationModel
{

    private \mysqli $databaseSingleton;
    private PHPMailer $mailer;

    private JWTModel $jwt;

    private AuthModel $aModel;

    public function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(BASE_PATH);
        $dotenv->load();          
        $this->databaseSingleton = DatabaseModel::getInstance()->getConnection();
        $this->mailer = new PHPMailer();
        $this->jwt = new JWTModel();
        $this->aModel = new AuthModel();
        try
        {
            $this->mailer->isSMTP();
            $this->mailer->Host       = $_ENV["SMTP"];   
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = $_ENV["SMTPUSER"];
            $this->mailer->Password   = $_ENV["SMTPPASS"];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $this->mailer->Port       = $_ENV["SMTPPORT"];
            $this->mailer->setFrom($_ENV["SMTPUSER"], $_ENV["EMAILNAME"]);            

        }catch(Exception $e)
        {
            die(var_dump($e));
        }
    }

    public function checkIfVerified(String $NIF) : bool
    {
        $sqlStatement = "SELECT emailVerified FROM usuario WHERE NIF = ?";

        $stmt = $this->databaseSingleton->prepare($sqlStatement);

        $stmt->bind_param("s", $NIF);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows <= 0) return false;

        $isVerified = $result->fetch_row();

        return $isVerified[0];  // 0 || 1
    }

    public function verifyUser(String $NIF) : bool
    {
        $isAlreadyVerified = $this->checkIfVerified($NIF);
        
        if($isAlreadyVerified) return false;

        $sqlStatement = "UPDATE usuario SET emailVerified = 1 WHERE NIF = ?";

        $stmt = $this->databaseSingleton->prepare($sqlStatement);

        $stmt->bind_param("s", $NIF);

        $stmt->execute();

        $result = $stmt->affected_rows;

        return $result === 1; // It just needs to modify one row.

    }

    public function sendANewMail(String $NIF, String $email) : void
    {
        try
        {
            $this->jwt->setPayload(["user" => $NIF, "context" => "emailVerification", "MAILEXPIRATION" => $_ENV["MAILEXPIRATION"]]);
            $url = "http://127.0.0.1/E3IWebPage/Auth/VerifyMail?token=".$this->jwt->getGeneratedToken();

            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Verifica tu cuenta en E3I';   
            
            $cuerpo = file_get_contents(BASE_PATH . '/public/GlobalAssets/others/mail.html');
            $dniEnmascarado = str_repeat('*', strlen($NIF) - 4) . substr($NIF, -4);

            $cuerpo = str_replace('{{LINK_VERIFICACION}}', $url, $cuerpo);

            $cuerpo = str_replace("{{DNI_USUARIO}}", $dniEnmascarado, $cuerpo);

            $this->mailer->Body = $cuerpo;
            
            $this->mailer->send();

        } catch (Exception $e)
        {
            die(var_dump($e));
        }

    }

    private function doReallyExist(String $email): bool
    {
        $sqlStatement = "SELECT * FROM usuario WHERE email = ?";

        $hashedEmail = hash("sha256", $email);

        $stmt = $this->databaseSingleton->prepare($sqlStatement);

        $stmt->bind_param("s", $hashedEmail);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows <= 0;

    }

    public function forgotPass(String $email) : bool
    {
        if($this->doReallyExist($email)) return false;

        try
        {
            $this->jwt->setPayload(["user" => $email, "context" => "forgotPass", "MAILEXPIRATION" => $_ENV["MAILEXPIRATION"]]);
            $url = "http://127.0.0.1/E3IWebPage/Auth/ForgotPass?token=".$this->jwt->getGeneratedToken();

            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Recupera tu acceso en E3I';   
            
            $cuerpo = file_get_contents(BASE_PATH . '/public/GlobalAssets/others/recover.html');

            $cuerpo = str_replace('{{LINK_VERIFICACION}}', $url, $cuerpo);

            $this->mailer->Body = $cuerpo;
            
            $this->mailer->send();

        } catch (Exception $e)
        {
            die(var_dump($e));
        }    
        
        return true;

    }   
    
    public function sendBill(String $email, String $name, String $orderId, String $fecha, String $total) : bool
    {
        try
        {

            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Confirmacion de pedido - E3I';   
            
            $cuerpo = file_get_contents(BASE_PATH . '/public/GlobalAssets/others/bill.html');

            $cuerpo = str_replace('{{NOMBRE_CLIENTE}}', $name, $cuerpo);

            $cuerpo = str_replace('{{PEDIDO}}', $orderId, $cuerpo);

            $cuerpo = str_replace('{{FECHA}}', $fecha, $cuerpo);

            $cuerpo = str_replace('{{TOTAL}}', $total, $cuerpo);

            $this->mailer->Body = $cuerpo;
            
            $this->mailer->send();

        } catch (Exception $e)
        {
            die(var_dump($e));
        }    
        
        return true;

    }     

    public function verifyLink(String $email, String $pass, String $token): bool
    {
        
        if(!$this->jwt->checkJWTTokenValidity($token)) return false;
        
        $nifEquivalente = $this->aModel->getNIF($email);

        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        $sqlStatement = "UPDATE usuario SET password = ? WHERE NIF = ?";

        $stmt = $this->databaseSingleton->prepare($sqlStatement);

        $stmt->bind_param("ss", $hashedPassword, $nifEquivalente);

        $stmt->execute();

        return $stmt->affected_rows === 1;

    }    


}