<?php
namespace App\Models\Param;


class ParamModel
{

    public function modifyParameter(string $email = "", string $telefono = "", string $quienes = "", string $empresas = "", string $ubicacion = "") : void
    {
        $filePath = BASE_PATH . "/public/GlobalAssets/others/details.json";
        
       
        $currentData = [];
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);

            $currentData = json_decode($jsonContent, true) ?? []; 
        }


        if($email !== "") $currentData["email"] = $email;
        if($telefono !== "") $currentData["telefono"] = $telefono;
        if($quienes !== "") $currentData["quienes"] = $quienes;
        if($empresas !== "") $currentData["empresas"] = $empresas;
        if($ubicacion !== "") $currentData["ubicacion"] = $ubicacion;


        file_put_contents($filePath, json_encode($currentData, JSON_PRETTY_PRINT), LOCK_EX);
    }

    public function getParams() : array
    {
        $filePath = BASE_PATH . "/public/GlobalAssets/others/details.json";
        $jsonContent = file_get_contents($filePath);

        return json_decode($jsonContent, true);
    }    

}