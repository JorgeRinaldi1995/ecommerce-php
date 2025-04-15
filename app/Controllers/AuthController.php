<?php

namespace App\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Core\Middleware\AuthMiddleware;

class AuthController {
    public function register() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
    
            // Verifica se todos os campos necessários estão presentes
            if (!isset($data['name'], $data['email'], $data['password'], $data['doc'])) {
                throw new \Exception('Dados incompletos. Todos os campos são obrigatórios.');
            }
    
            // Tenta criar o usuário
            if (User::create($data['name'], $data['email'], $data['password'], $data['doc'])) {
                echo json_encode(['message' => 'Usuário registrado com sucesso']);
            } else {
                throw new \Exception('Erro ao registrar usuário. Tente novamente mais tarde.');
            }
    
        } catch (\Exception $e) {
            // Define o código de resposta HTTP e retorna a mensagem de erro
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Throwable $t) {
            // Captura erros que não são exceções
            http_response_code(500);
            echo json_encode(['error' => 'Ocorreu um erro inesperado.']);
        }
    }

    public function login() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            // Verifica se os dados foram decodificados corretamente
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Erro ao decodificar os dados de entrada.');
            }
    
            // Verifica se o e-mail e a senha foram enviados
            if (!isset($data['email'], $data['password'])) {
                throw new \Exception('Email e senha são obrigatórios.');
            }
    
            // Busca o usuário pelo e-mail
            $user = User::findByEmail($data['email']);
    
            // Verifica se o usuário existe e se a senha está correta
            if ($user && password_verify($data['password'], $user['password'])) {
                $payload = [
                    'iss' => 'localhost',
                    'aud' => 'localhost',
                    'iat' => time(),
                    'exp' => time() + (60 * 60), // 1 hora
                    'uid' => $user['id']
                ];
    
                // Gera o token JWT
                $jwt = JWT::encode($payload, JWT_SECRET, 'HS256');
    
                echo json_encode(['token' => $jwt]);
            } else {
                throw new \Exception('Credenciais inválidas');
            }
    
        } catch (\Exception $e) {
            // Define o código de resposta HTTP e retorna a mensagem de erro
            http_response_code(401);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Throwable $t) {
            // Captura erros inesperados
            http_response_code(500);
            echo json_encode(['error' => $t->getMessage()]);
        }
    }

    public function me() {
        $user = AuthMiddleware::handle();
        try {
            echo json_encode(['user_id' => $user->uid]);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido']);
        }
        
    }
}
