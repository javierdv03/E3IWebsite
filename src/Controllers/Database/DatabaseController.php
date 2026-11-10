<?php

namespace App\Controllers\Database;

require_once dirname(__DIR__) . "/../Models/Database/DatabaseModel.php";

use App\Models\Database\DatabaseModel;


/**
 * Summary of DBOperations
 * This is an important component as define
 * almost every database operation that's used
 * in <b> all </b> the application.
 * 
 * 
 * @package DB\Operations
 */
class DatabaseController
{

    private \mysqli $conn;

    public function __construct()
    {

        $this->conn = DatabaseModel::getInstance()->getConnection();

    }
   

}


