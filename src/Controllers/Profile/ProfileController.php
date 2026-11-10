<?php
namespace App\Controllers\Profile;


require_once dirname(__DIR__) . "/../Models/Profile/ProfileModel.php";
require_once dirname(__DIR__) . "/../Models/JWT/JWTModel.php";

use App\Models\Profile\ProfileModel;
use App\Models\JWT\JWTModel;

class ProfileController
{
    private ProfileModel $pModel;

     private JWTModel $jModel;

    public function __construct()
    {
        $this->pModel = new ProfileModel();
        $this->jModel = new JWTModel();
    }

    public function modifyProfile(array $request): array
    {
        $password = $request["password"] ?? "";
        $rp = $request["r-password"] ?? "";

        if($password != "" && !hash_equals($password, $rp)) return ["httpCode" => 400, "content" => "Las contraseñas no son iguales."];

        $pk = $this->jModel->getEntity($request["AUTHENTICATOR"], "id");

        $nombre = $request["nombre"] ?? "";

        $apellidos = $request["apellidos"] ?? "";

        $this->pModel->modifyProfile($pk, $nombre, $apellidos, $password);

        return ["httpCode" => 200, "content" => "OK"];        
    }
}