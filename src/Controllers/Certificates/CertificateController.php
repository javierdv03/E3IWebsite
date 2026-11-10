<?php
namespace App\Controllers\Certificates;

require_once dirname(__DIR__) . "/../Models/Certificates/CertificateModel.php";

use App\Models\Certificate\CertificateModel;

class CertificateController
{
    private CertificateModel $cModel;

    public function __construct()
    {
        $this->cModel = new CertificateModel();
    }

    public function createCertificate(array $request): array
    {

        $nombre = $request["nombre"];

        $tipo = $request["tipo"];

        $precio = $request["precio"];

        $desc = $request["descripcion"];

        $this->cModel->addACert($nombre, $tipo, $precio, $desc);

        return ["httpCode" => 201, "content" => "OK"];

    }

    public function modifyCertificate(array $request): array
    {

        if(!isset($request["pk"])) return ["httpCode" => 400, "content" => "KO"];

        $pk = $request["pk"];

        $nombre = $request["nombre"] ?? "";

        $tipo = $request["tipo"] ?? "";

        $precio = $request["precio"] ?? "";

        $desc = $request["descripcion"] ?? "";

        $this->cModel->modifyACert($pk, $nombre, $tipo, $precio, $desc);

        return ["httpCode" => 200, "content" => "OK"];

    }
    
    public function deleteCertificate(array $request): array
    {

        if(!isset($request["pk"])) return ["httpCode" => 400, "content" => "KO"];

        $pk = $request["pk"];

        $this->cModel->deleteACert($pk);

        return ["httpCode" => 200, "content" => "OK"];

    }   
    
    public function getCertificate(array $request) : array
    {

        $getAll = $this->cModel->getCert();

        return ["httpCode" => 200, "content" => $getAll];

    }




}
