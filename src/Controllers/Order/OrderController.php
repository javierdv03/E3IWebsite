<?php
namespace App\Controllers\Order;

require_once dirname(__DIR__) . "/../Models/Order/OrderModel.php";
require_once dirname(__DIR__) . "/../Models/JWT/JWTModel.php";

use App\Models\Order\OrderModel;
use App\Models\JWT\JWTModel;

class OrderController
{
    private OrderModel $oModel;

    private JWTModel $jModel;

    public function __construct()
    {
        $this->oModel = new OrderModel();
        $this->jModel = new JWTModel();
    }

    public function getOrders(array $request): array
    {
        $userEntity = $this->jModel->getEntity($request["AUTHENTICATOR"], "id");

        return ["httpCode" => 200, "content" => $this->oModel->getOrders($userEntity)];

    }

    public function getOrder(array $request): array
    {
        $userEntity = $this->jModel->getEntity($request["AUTHENTICATOR"], "id");

        $result = $this->oModel->getOrder($userEntity, $request["idPedido"]);

        if(count($result) === 0) return ["httpCode" => 404, "content" => "No se ha encontrado el pedido para este usuario :("];

        return ["httpCode" => 200, "content" => $result];

    }    
    

}