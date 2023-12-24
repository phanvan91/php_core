<?php

namespace Core\DB;

use Core\Config;
use PDO;
use PDOException;

class DB
{
    private $host;
    private $port;
    private $dbName;
    private $userName;
    private $password;
    public $connect;

    public function __construct()
    {
        $this->host = Config::get('db.DB_HOST');
        $this->port = Config::get('db.DB_PORT');
        $this->dbName = Config::get('db.DB_DATABASE');
        $this->userName = Config::get('db.DB_USERNAME');
        $this->password = Config::get('db.DB_PASSWORD');
    }

    // get the database connection
    public function getConnection()
    {

        try {
            $this->connect = new PDO('mysql:host=' . $this->host . '; port=' . $this->port . '; dbname=' . $this->dbName, $this->userName, $this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connect;
        } catch (PDOException $e) {
            echo "Connection error " . $e->getMessage();
            exit;
        }
    }

    public static function getValueDB()
    {
        var_dump(self::host);
    }
}

?>