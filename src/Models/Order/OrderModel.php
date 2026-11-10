<?php
namespace App\Models\Order;

require_once dirname(__DIR__) . "/Database/DatabaseModel.php";

use App\Models\Database\DatabaseModel;

class OrderModel
{
    
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = DatabaseModel::getInstance()->getConnection();
    }

    public function getUserFromOrder(String $orderId): String
    {
        $sqlStatement = "SELECT NIF FROM pedido WHERE idPedido = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $orderId = (int) $orderId;

        $stmt->bind_param("i", $orderId);

        $stmt->execute();

        $result = $stmt->get_result();

        return  $result->num_rows === 1 ? (String) $result->fetch_row()[0] : "";
    }

    public function getOrders(String $nif): array
    {

        $sqlStatement = "SELECT producto.nombre AS NombreProducto, producto.precio AS PedidoPrecio, estado, anotacion, pedido.idPedido as idPedidoUsuario
                         FROM pedido
                         INNER JOIN producto ON pedido.idProducto = producto.idProducto
                         WHERE pedido.NIF = ?";
        
        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("s", $nif);

        $stmt->execute();       
        
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);   

    }

    public function getOrder(String $nif, String $idPedido): array
    {
        $realUser = $this->getUserFromOrder($idPedido);

        if(!hash_equals($realUser, $nif)) return [];

        $sqlStatement = "SELECT producto.nombre AS NombreProducto, producto.precio AS PedidoPrecio, estado, anotacion, pedido.idPedido AS idPedidoUsuario,
                         pedido.timestamp AS fechaPedido
                         FROM pedido
                         INNER JOIN producto ON pedido.idProducto = producto.idProducto
                         WHERE pedido.NIF = ? 
                         AND pedido.idPedido = ?";
        
        $stmt = $this->conn->prepare($sqlStatement);

        $idPedido = (int) $idPedido;

        $stmt->bind_param("si", $nif, $idPedido);

        $stmt->execute();       
        
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);   

    }

    
    public function insertOrder(String $address, String $region, String $zipcode, String $NIF, String $idProducto): void
    {
        $sqlStatement = "INSERT INTO pedido (NIF, idProducto, timestamp, direccion, zipcode, provincia) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sqlStatement);

        $currentTime = time();

        $stmt->bind_param("siisss", $NIF, $idProducto, $currentTime, $address, $zipcode, $region);

        $stmt->execute();
    }

}