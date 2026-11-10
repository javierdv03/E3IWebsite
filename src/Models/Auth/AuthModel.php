<?php
namespace App\Models\Auth;

use Exception;
require_once dirname(__DIR__) . "/Database/DatabaseModel.php";

use App\Models\Database\DatabaseModel;

class AuthModel
{
    private ?\mysqli $conn;

    public function __construct()
    {
        $this->conn = DatabaseModel::getInstance()->getConnection();
    }

    public function emailExist(String $email): bool
    {
        $sqlStatement = "SELECT * FROM usuario WHERE email = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $hashedEmail = hash("sha256", $email);

        $stmt->bind_param("s", $hashedEmail);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function NifExist(String $NIF): bool
    {
        $sqlStatement = "SELECT * FROM usuario WHERE NIF = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("s", $NIF);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function registerUser(String $NIF, String $name, String $surname, String $email, String $password, String $phone) : bool
    {
        $sqlStatement = "INSERT INTO usuario (NIF, email, password, nombre, apellidos, telefono, timestamp) VALUES (?,?,?,?,?,?,?)";

        $hashedEmail = hash("sha256", $email);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $hashedPhone = hash("sha256",$phone);

        $currentTime = time();

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("ssssssi", $NIF, $hashedEmail, $hashedPassword, $name, $surname, $hashedPhone, $currentTime);

        $stmt->execute();

        $anyError = $stmt->error; 
        
        return !empty($anyError); // falso => true

    }

    public function getName(String $email): string
    {
        $getNif = $this->getNIF($email);

        $sqlStatement = "SELECT nombre, apellidos FROM usuario WHERE NIF = ?";

        $stmt = $this->conn->prepare($sqlStatement);
        $stmt->bind_param("s", $getNif);
        $stmt->execute();

        $stmt->bind_result($nombre, $apellidos);

        if ($stmt->fetch()) {
            return trim($nombre . " " . $apellidos);
        }

        return "";
    }

    public function loginUser(String $email, String $password) : bool
    {
        $sqlStatement = "SELECT password FROM usuario WHERE email = ?";

        $hashedEmail = hash("sha256", $email);

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("s", $hashedEmail);

        $stmt->execute();

        if($stmt->error) throw new Exception("Error ", $stmt->error); 

        $stmt->bind_result($dbPasswordHash);

        return $stmt->fetch() ? password_verify($password, $dbPasswordHash) : false;

    }

    public function getNIF(String $email): String
    {
        $sqlStatement = "SELECT NIF FROM usuario WHERE email = ?";

        $hashedEmail = hash("sha256", $email);

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("s", $hashedEmail);

        $stmt->execute();

        if($stmt->error) throw new Exception("Error ", $stmt->error); 

        $stmt->bind_result($nif);

        return $stmt->fetch() ? $nif : "";
    }


    public function isAdmin(String $nif) : bool
    {
        $sqlStatement = "SELECT admin FROM usuario WHERE NIF = ?";
        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("s", $nif);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows <= 0) return false;

        $isVerified = $result->fetch_row();

        return $isVerified[0];  // 0 || 1
    }




}