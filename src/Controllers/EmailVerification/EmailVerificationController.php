<?php
namespace App\Controllers\EmailVerification;

require_once dirname(__DIR__) . "/../Models/EmailVerification/EmailVerificationModel.php";
require_once dirname(__DIR__) . "/../Models/JWT/JWTModel.php";
require_once dirname(__DIR__) . "/../reCAPTCHA/reCaptchaClass.php";


use App\Models\JWT\JWTModel;
use App\Models\EmailVerification\EmailVerificationModel;
use reCaptchaClass;

class EmailVerificationController
{

    private JWTModel $jwtM;

    private EmailVerificationModel $emailM;

    public function __construct()
    {
        $this->jwtM = new JWTModel();
        $this->emailM = new EmailVerificationModel();
    }


    public function verifyEmail(array $request) : array
    {
        if(!$this->jwtM->checkJWTTokenValidity($request["token"])) return ["httpCode" => 401, "content" => "No es válido o ha expirado."];

        $user = $this->jwtM->getEntity($request["token"], "user");

        if($this->emailM->checkIfVerified($user)) return ["httpCode" => 400, "content" => "Tu correo ya fue verificado"];
        
        $this->emailM->verifyUser($user);

        $this->jwtM->setPayload(["aud" => "/Auth/VerifyMail", "context" => "user"]);

        return ["httpCode" => 200, "content" => $this->jwtM->getGeneratedToken()];
        
    }

    public function forgotPass(array $request): array
    {
        $reCaptchaCheck = new reCaptchaClass($request["g-recaptcha-response"]);

        if(!$reCaptchaCheck->isAllowed()) return ["httpCode" => 401, "content" => "El captcha no es válido"]; 

        $this->emailM->forgotPass($request['email']);

        return ["httpCode" => 200, "content" => "Se ha enviado el email correctamente"];
    }

    public function verifyLink(array $request): array
    {
        $pass = $request["password"];
        $rpass = $request["r-password"];

        if(!hash_equals($pass, $rpass)) return ["httpCode" => 401, "content" => "Las contraseñas no coinciden"];        

        $result = $this->emailM->verifyLink($this->jwtM->getEntity($request["token"], "user"), $pass, $request["token"]);

        return $result ?
                ["httpCode" => 200, "content" => "Se ha cambiado la contraseña correctamente"]
                :
                ["httpCode" => 401, "content" => "El código ha expirado o nunca ha sido válido"];
    }

}