<?php
namespace App\Models\Database;

require_once dirname(__DIR__) ."/../../vendor/autoload.php";
require_once dirname( __DIR__) . "/../GlobalFiles/Constants.php";

/**
 * Summary of DBConnection
 * 
 * Inits a DB Connection
 * Database using singleton creational pattern
 * @package DB\DatabaseModel
 */
class DatabaseModel
{

    private \mysqli $conn;
    private static ?DatabaseModel  $instance = null;

    private function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(BASE_PATH);
        $dotenv->load();        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->conn = new \mysqli($_ENV["DBHOSTNAME"], $_ENV["DBUSERNAME"], $_ENV["DBPASSWORD"], $_ENV["DBCOMPANYNAME"]);
        $this->conn->set_charset("utf8mb4");

        if ($this->conn->connect_error)  throw new \Exception("Connection failed: " . $this->conn->connect_error);
         
        

    }
    private function __clone(): void {}
    public function __wakeup(): void
    {
        throw new \Exception("Cannot unserialize singleton");
    }

     /**
      * Summary of getInstance
      * 
      * Getter of DBConnection singleton instance.
      * @return DatabaseModel|null DBConnection instance
      */
     public static function getInstance(): DatabaseModel
    {
        if (self::$instance === null) self::$instance = new DatabaseModel();
                
        return self::$instance;
    }

    /**
     * Summary of getConnection
     * Gettter of mysqli connection instance
     * @return \mysqli mysqli instance
     */
    public function getConnection(): \mysqli
    {
        return $this->conn;
    }

}