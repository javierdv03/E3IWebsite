<?php
namespace App\Models\Sales;

require_once dirname(__DIR__) . "/Database/DatabaseModel.php";

use App\Models\Database\DatabaseModel;

class SalesModel
{
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = DatabaseModel::getInstance()->getConnection();
    }

    public function getSales(): array
    {
        $sqlStatement = "SELECT idPedido, pedido.NIF as NIF, estado, anotacion, producto.nombre AS nombreProducto, producto.precio AS precio, pedido.timestamp AS fechaPedido 
        FROM pedido 
        INNER JOIN usuario ON pedido.NIF = usuario.NIF 
        INNER JOIN producto ON pedido.idProducto = producto.idProducto";

        $stmt = $this->conn->prepare($sqlStatement);


        $stmt->execute();       
        
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);        
    }

    public function getSale(String $idPedido): Array
    {
        $sqlStatement = "SELECT estado, anotacion, producto.nombre as nombre 
                        FROM pedido 
                        INNER JOIN producto ON pedido.idProducto = producto.idProducto
                        WHERE idPedido = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("s", $idPedido);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);         
    }

    public function modifySale(String $idPedido, String $estado, String $anotacion = "") : bool
    {
        $fields = [];
        $params = [];
        $types = "";

  
        $fields[] = "estado = ?";
        $params[] = $estado;
        $types .= "s"; // string
        
        if ($anotacion !== "") {
            $fields[] = "anotacion = ?";
            $params[] = $anotacion;
            $types .= "s"; // asumiendo que precio es string; si es float, usar "d"
        }


        // Si no hay campos a modificar, salimos
        if (empty($fields)) {
            return false;
        }

        // Construimos la consulta dinámica
        $sqlStatement = "UPDATE pedido SET " . implode(", ", $fields) . " WHERE idPedido = ?";
        $params[] = $idPedido;
        $types .= "i"; 

        $stmt = $this->conn->prepare($sqlStatement);
        if ($stmt === false) {
            return false;
        }

        // Vinculamos parámetros dinámicamente
        $stmt->bind_param($types, ...$params);

        // Ejecutamos y retornamos el resultado
        return $stmt->execute();        
    }

    public function salesStats(): array
    {
        
        $now = time();
        $weekAgoTimestamp = $now - (7 * 24 * 60 * 60);       
        $twoWeeksAgoTimestamp = $now - (14 * 24 * 60 * 60);  

        $sqlStatement = "SELECT 
                        SUM(CASE WHEN timestamp >= ? THEN 1 ELSE 0 END) AS VentasEstaSemana, 
                        SUM(CASE WHEN timestamp >= ? AND timestamp < ? THEN 1 ELSE 0 END) AS VentasSemanaPasada
                        FROM pedido 
                        WHERE timestamp >= ?";
        
        $stmt = $this->conn->prepare($sqlStatement);

        
        $stmt->bind_param("iiii", 
            $weekAgoTimestamp,      
            $twoWeeksAgoTimestamp,  
            $weekAgoTimestamp,      
            $twoWeeksAgoTimestamp   
        );

        $stmt->execute();
        $stmt->bind_result($ventasEstaSemana, $ventasSemanaPasada);
        $stmt->fetch();
        
        return [$ventasEstaSemana, $ventasSemanaPasada];
                         
    }
}