<?php
namespace S;

class Database {
    private static $connection;

    /**
     * @var string $connectString
     */
    protected $connectString;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Database
    {
        if (!isset(static::$connection)) {
            static::$connection = new static;
        }

        return static::$connection;
    }

    public function setConnectString(string $connectString) : Database
    {
        $this->connectString = $connectString;

        return $this;
    }

    public function getConnectString() : string {
        return $this->connectString;
    }
}

class MariaDB extends Database
{
    private static $connection;

    public static function getInstance(): Database
    {
        if (!isset(static::$connection)) {
            static::$connection = new static;
        }

        return static::$connection;
    }
}

class MongoDB extends Database
{
    private static $connection;

    public static function getInstance(): Database
    {
        if (!isset(static::$connection)) {
            static::$connection = new static;
        }

        return static::$connection;
    }
}

//test
$database1 = Database::getInstance();
$database1->setConnectString('mysql://');

$database2 = Database::getInstance();
$database2->setConnectString('mysqli://');

$mariaDB = MariaDB::getInstance();
$mariaDB->setConnectString('maria-db://');

$mongoDB = MongoDB::getInstance();
$mongoDB->setConnectString('mongodb://');

var_dump($database1->getConnectString());
var_dump($database2->getConnectString());
var_dump($mariaDB->getConnectString());
var_dump($mongoDB->getConnectString());

