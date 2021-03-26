<?php
namespace core;

use \PDO;

class ConnectDB
{
    private static $connectDB = null;
    public static function connectDB()
    {
        if (!self::$connectDB) {
            try {
                self::$connectDB = new PDO("mysql:host=". SERVER_NAME . "; dbname=" . DB_NAME, USER_NAME, PASSWORD);
                self::$connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $error = "Connect failed: " . $e->getMessage;
                die();
            }
        }
        return self::$connectDB;

    }
    private function __construct(){}
    private function __clone(){}
    private function __destruct()
    {
        self::$connectDB = null;
    }
}