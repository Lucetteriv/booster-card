<?php

namespace App\Database;

use PDO;

use PDOException;

class Database{
    private static ?PDO $instance = null;
    public static function getConnection(): PDO
    {
        if(self::$instance === null){
            $databasePath = dirname(__DIR__, 2) . "/database/db.sqlite";
            $dsn = "sqlite:" . $databasePath;
            try{
                self::$instance = new PDO($dsn);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e){
                die($e->getMessage());
            }
        }

        return self::$instance;
    }
}