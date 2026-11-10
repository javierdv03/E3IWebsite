<?php
namespace App\Controllers\Sales;

require_once dirname(__DIR__) . "/../Models/Sales/SalesModel.php";
require_once dirname(__DIR__) . "/../Utils.php";

use App\Models\Sales\SalesModel;

class SalesController
{
    private SalesModel $sModel;

    public function __construct()
    {
        $this->sModel = new SalesModel();
    }


    public function getSales(array $request): array
    {
        $result = $this->sModel->getSales();

        return ["httpCode" => 200, "content" => $result];
    }

    public function getSale(array $request): array
    {
        $result = $this->sModel->getSale($request["idPedido"]);

        return $result ? 
                ["httpCode" => 200, "content" => $result]
                :
                ["httpCode" => 404, "content" => "Pedido no encontrado"];
    }

    public function modifySale(array $request) : array
    {
        $anotacion = $request["anotacion"] ?? "";

        $estado = $request["estado"] ?? "no";

        $this->sModel->modifySale($request["idPedido"], $estado, $anotacion);

        return ["httpCode" => 200, "content" => "Ok"];

    }
    public function salesStats(array $request) : array
    {

         $stats = $this->sModel->salesStats();

         $summary =
         [
            "estaSemana" => $stats[0],
            "semanaPasada" => $stats[1],
            "porcentaje" => calcularPorcentaje($stats[0], $stats[1]) 
         ];

        return ["httpCode" => 200, "content" => $summary];

    }    

}