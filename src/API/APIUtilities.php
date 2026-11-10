<?php

/**
 * Summary of APIUtilities
 * 
 * Basis content of every api endpoint. This class will inject every single method that 
 * by default is needed in an endpoint :P
 * @package API\Utilities
 * @abstract
 */
abstract class APIUtilities
{

    /**
     * Summary of getValues
     * 
     * Just a way to compilate the different values
     * depending of the type of request.
     * 
     * @param string $method HTTP Request method
     * @return array sent values
     */

    private function getValues(String $method) : array
    {
        if(in_array($method, ["PUT", "PATCH", "DELETE"]))
             return !file_get_contents('php://input')
               ?
                [] 
               : 
                json_decode(file_get_contents('php://input'), true);
        
        return $method === "GET" ? $_GET : $_POST;
    }
  
    /**
     * Summary of requestSummary
     * 
     * As a way to have encapsulate the important of a request.
     * @return array{LOOKED_RESOURCE: string, REQUEST_METHOD: string, VALUES: array} unified & structured request data
     */
    public function requestSummary() : array
    {
        return [

            "REQUEST_METHOD" => $_SERVER['REQUEST_METHOD'],
            "LOOKED_RESOURCE" => urldecode($_SERVER['REQUEST_URI']),
            "VALUES" => $this->getValues($_SERVER["REQUEST_METHOD"]),
            "AUTHENTICATOR" => getallheaders()["X-Authenticator"] ?? ""
        ];
    }

    /**
     * Summary of proccessResponse
     * 
     * It converts a text-plane request into a JSON.
     * It's abstract in case the endpoints needs a specific way to implement it (in a future)
     * @abstract
     * @param int $httpCode http code
     * @param string $response result of transaction
     * @return void
     */
    abstract public function proccessResponse(int $httpCode, string $response) : string;


}