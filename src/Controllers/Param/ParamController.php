<?php
namespace App\Controllers\Param;

require_once dirname(__DIR__) . "/../Models/Param/ParamModel.php";

use App\Models\Param\ParamModel;

class ParamController
{
    private ParamModel $pModel;

    public function __construct()
    {
        $this->pModel = new ParamModel();
    }


    public function modifyParam(array $request): array
    {

        $ubicacion = $request["ubicacion"] ?? "";

        $empresas = $request["empresas"] ?? "";

        $email = $request["email"] ?? "";
        
        $telefono = $request["telefono"] ?? "";

        $quienes = $request["quienes"] ?? "";

        $this->pModel->modifyParameter($email, $telefono, $quienes, $empresas, $ubicacion);

        return ["httpCode" => 200, "content" => "Ok"];

    }
}