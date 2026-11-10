<?php
namespace App\Controllers\Admin;

require_once dirname(__DIR__) . "/../Models/Admin/AdminModel.php";

use App\Models\Admin\AdminModel;

class AdminController
{
    private AdminModel $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }


    public function addAdmin(array $request) : array
    {

        $result = $this->adminModel->addAdmin($request["email"]);

        return $result ?
                ["httpCode" => 200, "content" => "OK"]
                :
                ["httpCode" => 400, "content" => "El email proporcionado no existe"];


    }

}