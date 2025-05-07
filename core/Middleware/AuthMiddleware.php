<?php

namespace Core\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

class AuthMiddleware {

    public static function generate($useId){
        $payload = [
            'iss' => 'localhost',
            'aud' => 'localhost',
            'iat' => time(),
            'exp' => time() + (60 * 60), // 1 hora
            'uid' => $useId['id']
        ];

        return JWT::encode($payload, JWT_SECRET, 'HS256');
    }
    
    public static function handle(): ?object {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token = null;
    
        // Tenta extrair o token do header Authorization
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }
    
        // Se não tiver Authorization, tenta pegar do cookie
        if (!$token && isset($_COOKIE['jwt'])) {
            $token = $_COOKIE['jwt'];
        }
    
        if ($token) {
            try {
                return JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
            } catch (\Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Token inválido ou expirado']);
                exit;
            }
        }
    
        http_response_code(401);
        echo json_encode(['error' => 'Token não fornecido']);
        exit;
    }

    // Core/Middleware/AuthMiddleware.php
    public static function requireRole(array $allowedRoles): object {
        $user = self::handle(); // já decodifica e valida o token
        $userData = User::findById($user->uid);

        if (!$userData || !in_array((int) $userData['role'], $allowedRoles)) {
            http_response_code(403);
            echo json_encode(['error' => 'Acesso negado: permissão insuficiente.']);
            exit;
        }

        return (object) $userData; // retorna os dados do usuário autorizado
    }

}
