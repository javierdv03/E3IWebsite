<?php
namespace App\Controllers\Visitor;

require_once dirname(__DIR__) . "/../Models/Visitor/VisitorModel.php";

use App\Models\Visitor\VisitorModel;

class VisitorController
{
    private VisitorModel $vModel;

    public function __construct()
    {
        $this->vModel = new VisitorModel();
    }

    public function getVisitors(array $request): array
    {
        $getV = $this->vModel->getVisitors();

        return ["httpCode" => 200, "content" => $getV];
    }


    public function updateVisitors(array $request): array
    {
        $this->vModel->updateVisitors();

        return ["httpCode" => 200, "content" => "OK"];
    }

}