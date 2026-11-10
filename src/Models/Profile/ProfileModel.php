<?php
namespace App\Models\Profile;

require_once dirname(__DIR__) . "/Database/DatabaseModel.php";

use App\Models\Database\DatabaseModel;

class ProfileModel
{
    
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = DatabaseModel::getInstance()->getConnection();
    }

    public function modifyProfile(String $NIF, String $name = "", String $surname = "", String $password = ""): bool
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
        if ($password !== "") {
            $fields[] = "password = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
            $types .= "s";
        }

        // Si no hay campos a modificar, salimos
        if (empty($fields)) {
            return false;
        }

        // Construimos la consulta dinámica
        $sqlStatement = "UPDATE usuario SET " . implode(", ", $fields) . " WHERE NIF = ?";
        $params[] = $NIF;
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