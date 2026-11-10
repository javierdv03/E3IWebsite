<?php
namespace App\Models\Customer;

require_once dirname(__DIR__) . "/Database/DatabaseModel.php";

use App\Models\Database\DatabaseModel;


class CustomerModel
{
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = DatabaseModel::getInstance()->getConnection();
    }

    public function getCustomers(): array
    { 
        $sqlStatement = "SELECT NIF, nombre, apellidos FROM usuario; ";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function getCustomer(String $NIF): array
    { 
        $sqlStatement = "SELECT nombre, apellidos FROM usuario WHERE NIF = ? ";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("s", $NIF);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);

    } 
    
    public function modifyACustomer(String $pk, String $name = "", String $surname = "", String $email = "", String $phone = ""): bool
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
        if ($surname !== "") {
            $fields[] = "apellidos = ?";
            $params[] = $surname;
            $types .= "s"; // asumiendo que precio es string; si es float, usar "d"
        }
        if ($email !== "") {
            $fields[] = "email = ?";
            $params[] = hash("sha256", $email);;
            $types .= "s";
        }
        if ($phone !== "") {
            $fields[] = "telefono = ?";
            $params[] = hash("sha256", $phone);;
            $types .= "s"; // asumiendo que idTipo es entero
        }

        // Si no hay campos a modificar, salimos
        if (empty($fields)) {
            return false;
        }

        // Construimos la consulta dinámica
        $sqlStatement = "UPDATE usuario SET " . implode(", ", $fields) . " WHERE NIF = ?";
        $params[] = $pk;
        $types .= "s"; // asumiendo que idProducto es entero

        $stmt = $this->conn->prepare($sqlStatement);
        if ($stmt === false) {
            return false;
        }

        // Vinculamos parámetros dinámicamente
        $stmt->bind_param($types, ...$params);

        // Ejecutamos y retornamos el resultado
        return $stmt->execute();
    }    
}