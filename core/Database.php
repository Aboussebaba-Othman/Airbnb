<?php

namespace Core;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database {
    private static $pdo;

    public static function getInstance() {
        if (!self::$pdo) {
            $dotenv = Dotenv::createImmutable(__DIR__.'/../');
            $dotenv->load();

            $dsn = "pgsql:host=".$_ENV["DB_HOST"].";port=".$_ENV["DB_PORT"].";dbname=".$_ENV["DB_DATABASE"].";";
            $user = $_ENV["DB_USERNAME"];
            $password = $_ENV["DB_PASSWORD"];

            try {
                self::$pdo = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
