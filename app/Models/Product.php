<?php

namespace App\Models;

use Core\Database;
use PDO;

class Product {
    public static function all(): array {
        $pdo = Database::connect();
        $stmt = $pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}