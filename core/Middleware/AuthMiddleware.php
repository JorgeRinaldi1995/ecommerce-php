<?php

namespace Core\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    public static function handle(): ?object {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
            try {
                return JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
            } catch (\Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Token inválido ou expirado']);
                exit;
            }
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Token não fornecido']);
            exit;
        }
    }
}
