<?php

namespace App\Models;

use Core\Database;
use PDO;

class User {
    public static function findByEmail(string $email): ?array {
        $stmt = Database::connect()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function create(string $name, string $email, string $password, string $doc, int $role): bool {
        $stmt = Database::connect()->prepare("INSERT INTO users (name, email, password, doc, role) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $doc, $role]);
    }

    public static function findById($id) {
        $stmt = Database::connect()->prepare('SELECT id, name, email, role FROM users WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
