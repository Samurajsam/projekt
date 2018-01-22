<?php
class Database
{
    private static $dbName = "projekt";
    private static $dbHost = "";
    private static $dbUser = "root";
    private static $dbUserPassword = '';
    private static $cont = null;
    public function __construct() {
        die('Init function is not allowed');
    }
    public static function connect() {
        if (null === self::$cont) {
            try {
                self::$cont =  new PDO('mysql:host='.self::$dbHost.'; dbname='.self::$dbName, self::$dbUser, self::$dbUserPassword);
            } catch(PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }
    public static function disconnect() {
        self::$cont = null;
    }
}
