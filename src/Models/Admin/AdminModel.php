<?php
namespace App\Models\Admin;

require_once dirname(__DIR__) . "/Database/DatabaseModel.php";
require_once dirname(__DIR__) . "/Auth/AuthModel.php";

use App\Models\Database\DatabaseModel;
use App\Models\Auth\AuthModel;

class AdminModel
{
    private \mysqli $conn;

    private AuthModel $authModel;

    public function __construct()
    {
        $this->conn = DatabaseModel::getInstance()->getConnection();
        $this->authModel = new AuthModel();
    }

    public function addAdmin(String $email): bool
    {
        
        $NIF = $this->authModel->getNIF($email);

        if(!$NIF || $NIF === "") return false;

        $sqlStatement = "UPDATE usuario SET admin = 1 WHERE NIF = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("s", $NIF);

        $stmt->execute();

        return $stmt->affected_rows === 1;

    }

}