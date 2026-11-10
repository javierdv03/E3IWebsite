<?php
namespace App\Models\Visitor;
require_once dirname(__DIR__) . "/../Utils.php";

class VisitorModel
{

    public function getVisitors(): array
    {
        $filePath = BASE_PATH . "/public/GlobalAssets/others/visitors.json";
        $jsonContent = file_get_contents($filePath);

        return json_decode($jsonContent, true);
    }

    public function updateVisitors() : void
    {
        $filePath = BASE_PATH . "/public/GlobalAssets/others/visitors.json";
        
        
        $currentData = [];
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $currentData = json_decode($jsonContent, true) ?? []; 
        }


        if (!isset($currentData["lastWeekTimestamp"])) {
            $currentData["lastWeekTimestamp"] = time();
            $currentData["thisWeek"] = 0;
            $currentData["lastWeek"] = 0;
        }

        
        if ((time() - $currentData["lastWeekTimestamp"]) >= 604800) {
            
        
            $currentData["lastWeek"] = $currentData["thisWeek"];
            
            
            $currentData["thisWeek"] = 0;
            
            
            $currentData["lastWeekTimestamp"] = time(); 
            
            
            $currentData["lastUpdated"] = time();
        }


        $currentData["thisWeek"] = (int)($currentData["thisWeek"] ?? 0) + 1;


        $currentData["percentage"] = calcularPorcentaje($currentData["thisWeek"], $currentData["lastWeek"]);


       
        file_put_contents($filePath, json_encode($currentData, JSON_PRETTY_PRINT), LOCK_EX);
    }

}