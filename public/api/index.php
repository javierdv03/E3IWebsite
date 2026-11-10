<?php
error_reporting(E_ALL);
require_once dirname(__DIR__) . "/../src/API/APIRouter.php";

try {

   new APIRouter();

} catch (\Throwable $th) {
    die(var_dump($th));
}
