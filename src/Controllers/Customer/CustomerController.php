<?php

namespace App\Controllers\Customer;

require_once dirname(__DIR__) . "/../Models/Customer/CustomerModel.php";

use App\Models\Customer\CustomerModel;

class CustomerController
{
    private CustomerModel $cModel;

    public function __construct()
    {
        $this->cModel = new CustomerModel();
    }


    public function getCustomers(array $request) : array
    {
        $result = $this->cModel->getCustomers();

        return ["httpCode" => 200, "content" => $result];
    }

    public function getCustomer(array $request) : array
    {
        $result = $this->cModel->getCustomer($request["NIF"]);

        return ["httpCode" => 200, "content" => $result];
    }

    public function modifyCustomer(array $request) : array
    {

        if(!isset($request["NIF"])) return ["httpCode" => 400, "content" => "KO"];

        $pk = $request["NIF"];

        $nombre = $request["nombre"] ?? "";

        $apellidos = $request["apellidos"] ?? "";

        $email = $request["email"] ?? "";

        $telefono = $request["telefono"] ?? "";

        $this->cModel->modifyACustomer($pk, $nombre, $apellidos, $email, $telefono);

        return ["httpCode" => 200, "content" => "OK"];
    }    
    
}