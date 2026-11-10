<?php

require_once dirname(__DIR__) ."/../vendor/autoload.php";
require_once dirname(__DIR__) . "/GlobalFiles/Constants.php";

class reCaptchaClass
{
    public array $requestInfo;
    private $captchaResponse;

    public function __construct(String $response)
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(BASE_PATH);
        $dotenv->load();           
        
        $this->requestInfo["response"] = $response;

        $this->requestInfo["secret"] = $_ENV["RECAPTCHA"]; 
        
    }

    public function isAllowed(): bool
    {
        
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$this->requestInfo["secret"]."&response=".$this->requestInfo["response"]);
        
        if (!$response) return false;

        $decodedResponse = json_decode($response);

        $this->setcaptchaResponse($decodedResponse);

        return $decodedResponse->success ?? false;
    }

    public function setcaptchaResponse(stdClass $info): void
    {
        $this->captchaResponse = $info;
    }

    public function getcaptchaResponse(): String
    {
        return json_encode($this->captchaResponse);
    }
}