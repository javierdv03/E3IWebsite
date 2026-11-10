<?php
namespace App\Controllers\Payment;

require_once dirname(__DIR__) . "/../Models/Payment/PaymentModel.php";

use App\Models\Payment\PaymentModel;

class PaymentController
{
    private PaymentModel $pModel;

    public function __construct()
    {
        $this->pModel = new PaymentModel();
    }


    public function makePayment(array $request): array
    {
        $result = $this->pModel->doPayment($request["envioDireccion"], $request["envioCiudad"], $request["envioProvincia"], $request["envioCP"], $request["pagoTarjeta"], $request["pagoMes"], $request["pagoAnio"], $request["pagoCvv"], $request["pagoNombre"] );

        if($result["error"] === "true") return ["httpCode" => 400, "content" => $result["reason"]];

        return $result["error"] === "medium" ?
                ["httpCode" => 202, "content" => $result["reason"]]
                :
                ["httpCode" => 200, "content" => "El pago ha sido exitoso"];
    }

}