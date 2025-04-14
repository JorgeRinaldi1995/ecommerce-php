<?php

namespace Core;

class Database {
    private static ?\PDO $pdo = null;

    public static function connect(): \PDO {
        if (!self::$pdo){
            try {
                self::$pdo = new \PDO('mysql:host=localhost:3306;dbname=ecommerce;charset=utf8', 'ecom_user', 'ecom_user');
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                die("Deu pica na base" . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}