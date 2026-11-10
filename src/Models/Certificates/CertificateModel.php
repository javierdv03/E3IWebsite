<?php
namespace App\Models\Certificate;

require_once dirname(__DIR__) . "/Database/DatabaseModel.php";

use App\Models\Database\DatabaseModel;

class CertificateModel
{
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = DatabaseModel::getInstance()->getConnection();
    }



    public function noExists(String $certId): bool
    {
        $sqlStatement = "SELECT * FROM producto WHERE idProducto = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("i", $certId);

        $stmt->execute();

        $result = $stmt->get_result()->fetch_row();

        return !$result;
    }

    public function getCert() : array
    {
        $sqlStatement = "SELECT * FROM producto";

        $stmt = $this->conn->prepare($sqlStatement);


        $stmt->execute();       
        
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSpecificCert(String $id): array
    {
        $doExist = $this->noExists($id);
        
        if($doExist) return [];

        $sqlStatement = "SELECT * FROM producto WHERE idProducto = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("i", $id);

        $stmt->execute();       
        
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);   
    }

    public function getPrice(String $idProduct) : String
    {
        $sqlStatement = "SELECT * FROM producto WHERE idProducto = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("i", $idProduct);

        $stmt->execute();       
        
        $result = $stmt->get_result();

        $item = $result->fetch_all(MYSQLI_ASSOC)[0];

        return $item["precio"];        
    }

    public function addACert(String $name, String $type, String $price, String $desc): bool
    {

        $sqlStatement = "INSERT INTO producto (tipo, nombre, precio, descripcion) VALUES (?,?,?,?)";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("ssss", $name, $type, $price, $desc);

        return $stmt->execute();

    }

    public function modifyACert(String $pk, String $name = "", String $type = "", String $price = "", String $desc = ""): bool
    {
        $fields = [];
        $params = [];
        $types = "";

        // Agregamos los campos solo si tienen valor
        if ($name !== "") {
            $fields[] = "nombre = ?";
            $params[] = $name;
            $types .= "s"; // string
        }
        if ($price !== "") {
            $fields[] = "precio = ?";
            $params[] = $price;
            $types .= "s"; // asumiendo que precio es string; si es float, usar "d"
        }
        if ($desc !== "") {
            $fields[] = "descripcion = ?";
            $params[] = $desc;
            $types .= "s";
        }
        if ($type !== "") {
            $fields[] = "tipo = ?";
            $params[] = $type;
            $types .= "s"; // asumiendo que idTipo es entero
        }

        // Si no hay campos a modificar, salimos
        if (empty($fields)) {
            return false;
        }

        // Construimos la consulta dinámica
        $sqlStatement = "UPDATE producto SET " . implode(", ", $fields) . " WHERE idProducto = ?";
        $params[] = $pk;
        $types .= "i"; // asumiendo que idProducto es entero

        $stmt = $this->conn->prepare($sqlStatement);
        if ($stmt === false) {
            return false;
        }

        // Vinculamos parámetros dinámicamente
        $stmt->bind_param($types, ...$params);

        // Ejecutamos y retornamos el resultado
        return $stmt->execute();
    }

    public function deleteACert(String $pk): bool
    {
        $pk = (int) $pk;

        $sqlStatement = "DELETE FROM producto WHERE idProducto = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("i", $pk);

        return $stmt->execute();

    }


}