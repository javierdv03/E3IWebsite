<?php


require_once dirname(__DIR__) . "/../vendor/autoload.php";
require_once dirname(__DIR__) . "/API/APIUtilities.php";
require_once dirname(__DIR__) . "/GlobalFiles/Constants.php";
require_once dirname(__DIR__) . "/RouteNormalizer/RouteNormalizerClass.php";
require_once dirname(__DIR__) . "/Models/JWT/JWTModel.php";

use App\Models\JWT\JWTModel;


/**
 * Summary of APIRouter
 * 
 * As it's name claim, is the API component that
 * uses the endpoints by invoking the needed component
 * through using dynamic spawn routes invoking thanks
 * to PSR-4 classes autoload.
 * 
 * @package API\Router
 * @extends APIUtilities
 */
class APIRouter extends APIUtilities
{
    private ?JWTModel $jwtInstance;
    
    public function __construct()
    {
        
        $this->jwtInstance = new JWTModel();
        $requestContext = $this->requestSummary();
        $target = new RouteNormalizer($requestContext["LOOKED_RESOURCE"]);

        if(!array_key_exists($target->get(0), EXPECTEDAPIFLOWS )) exit($this->proccessResponse(404, "The asset you are trying to access does not exist."));
        
        $endpoint = EXPECTEDAPIFLOWS[$target->get(0)];


        // Contextual check :P
        if($endpoint[$target->__tostring()]["Critical"])  
        {
           if(!$this->jwtInstance->checkJWTTokenValidity($requestContext["AUTHENTICATOR"])
            ||
              !hash_equals($endpoint[$target->__tostring()]["Context"], $this->jwtInstance->getEntity($requestContext["AUTHENTICATOR"], "context"))) exit($this->proccessResponse(401, "You are not allowed to do that."));

        }    


        $this->proccessRequest($target, $requestContext);

    }

    /**
     * Summary of proccessRequest
     * 
     * Given an endpoint, tries to invokes the class and method
     * in charge to manage that request. Looks magical and pretty generic
     * but that's thanks to PSR-4 and Constants.php hierarchy structure.
     * 
     * This method can be said that's strict, if the specified conditions are not met
     * it will reject the request, even if the endpoint exists. The conditions are imposed by the Constants.php file
     * but in brief: 
     * - Static Parameters, no one more, no one minus.
     * - Regex validation of it's content before passing them to invokers.
     * - As obvious, if the method mismatch to the specified, it will reject the request.
     * 
     * @param RouteNormalizer $route endpoint requested
     * @param array $context request content
     * @return never
     */
    private function proccessRequest(RouteNormalizer $route, array $context) : void
    {
        $response = ["httpCode" => 404, "content" => "The asset you are trying to access does not exist."];

        $endpoint = EXPECTEDAPIFLOWS[$route->get(0)];


        if(isset($endpoint[$route->__tostring()])) 
        {

            $unpackedItem = $endpoint[$route->__tostring()];

            if($unpackedItem["Method"] != $context["REQUEST_METHOD"])
                exit($this->proccessResponse(405, "The HTTP Method used is not suitable for this endpoint"));

            
            if(!$this->requestVerifier($context["VALUES"] ?? [], $unpackedItem["Params"])) 
                exit($this->proccessResponse(400, "The request did not match it's specifications"));


            [$class, $method] = $unpackedItem["Controller"];


            if (!class_exists($class))  
                exit($this->proccessResponse(500, "Handler class may have not be loaded! :C"));

            $controller = new $class();

            if(!method_exists($controller, $method))
                exit($this->proccessResponse(500, "Handler method may have not be loaded! :C"));

            $context["VALUES"]["AUTHENTICATOR"] = $context["AUTHENTICATOR"];
            
            $response = $controller->$method($context["VALUES"]);

        }

        exit($this->proccessResponse($response["httpCode"], $response["content"]));
        
       
    }

    /**
     * Summary of requestVerifier
     * 
     * To enhance the request security, requests are verified before invoking any
     * controller. The checks are: 
     * - Static Parameters, no one more, no one minus.
     * - Regex validation of it's content before passing them to invokers.
     * 
     * And totally customizable at Constants.php file.
     * 
     * @param array $param parameters sent by client
     * @param array $paramInfo parameters guideline
     * @return bool if valid or not
     */
    private function requestVerifier(array $param, array $paramInfo) : bool
    {

        if(count($param) > $paramInfo["ExpectedMaxCount"] ) return false;

        $intersectNeccesaryParams = array_intersect_key($param, $paramInfo["MandatoryParams"]);

        if(count($intersectNeccesaryParams) != $paramInfo["ExpectedMinCount"]) return false; 

        $mixedParams = array_merge($paramInfo["MandatoryParams"], $paramInfo["OptionalParams"]);

        foreach ($param as $key => $value) 
        {
            if(!isset($mixedParams[$key]) || !preg_match($mixedParams[$key], $value)) return false;
        } 

        return true;
    }

    /**
     * Summary of proccessResponse
     * 
     * Proccess the request and returns it in JSON.
     * 
     * @param int $httpCode http status code
     * @param mixed $content content to be served
     * @return string json structured content
     */
    public function proccessResponse(int $httpCode, mixed $content) : string
    {
        header("Content-Type: application/json");
        http_response_code($httpCode);

        return json_encode(["statusCode" => $httpCode, "response" => $content]);
    }

}

