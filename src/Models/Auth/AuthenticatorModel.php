<?php
namespace App\Models\Auth\Authenticator;

require_once dirname(__DIR__) . "/../../vendor/autoload.php";
require_once dirname(__DIR__) . "/Database/DatabaseModel.php";
require_once dirname(__DIR__) . "/Auth/AuthModel.php";

use PragmaRX\Google2FA\Google2FA;
use App\Models\Auth\AuthModel;
use App\Models\Database\DatabaseModel;

class AuthenticatorModel
{
    private \mysqli $conn;
    private AuthModel $authme; 

    public function __construct()
    {
        $this->conn = DatabaseModel::getInstance()->getConnection();
        $this->authme  = new AuthModel();
    }


    public function set2FA(String $NIF): mixed
    {
        $doExist = $this->authme->NifExist($NIF);

        if(!$doExist) return false;

        $g2FA = new Google2FA();

        $secretGen = $g2FA->generateSecretKey();

        $sqlStatement = "UPDATE usuario SET 2faSecret = ? WHERE NIF = ?"; 

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("ss", $secretGen, $NIF);

        $stmt->execute();

        return $stmt->affected_rows === 1 ? $g2FA->getQRCodeUrl("E3IWebPage", $NIF, $secretGen) : false;

    }


    private function getPrivateKey(String $NIF): mixed
    {
        $sqlStatement = "SELECT 2faSecret FROM usuario WHERE NIF = ?";

        $stmt = $this->conn->prepare($sqlStatement);

        $stmt->bind_param("s", $NIF);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0) return (String) $result->fetch_row()[0];

        return false;    
    }


    public function verifyCode(String $input, String $NIF) : bool
    {
        $secretToken = $this->getPrivateKey($NIF);

        if(!$secretToken) return false;

        $g2FA = new Google2FA();

        return $g2FA->verifyKey($secretToken, $input, 2);
    }

}


