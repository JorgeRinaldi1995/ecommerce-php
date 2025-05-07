<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use Firebase\JWT\JWT;
use Core\Middleware\AuthMiddleware;

class AuthController extends Controller{
    public function register() {
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Verifica se todos os campos necessários estão presentes
            if (!isset($data['name'], $data['email'], $data['password'], $data['doc'])) {
                throw new \Exception('Dados incompletos. Todos os campos são obrigatórios.');
            }
            
            // Tenta criar o usuário
            if (User::create($data['name'], $data['email'], $data['password'], $data['doc'], $data['role'])) {
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
            echo json_encode(['error' => $t->getMessage()]);
        }
    }

    public function login() {
        try {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
    
            $user = User::findByEmail($email);
            
            if ($user && password_verify($password, $user['password'])) {
                $token = AuthMiddleware::generate($user);
                setcookie('jwt', $token, time() + 3600, '/', '', false, true);
                header('Location: /dashboard');
                exit;
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

    public function showLoginForm() {
        $requestUri = $_SERVER['REQUEST_URI'];

        // Remove parâmetros da query string (se houver)
        $path = parse_url($requestUri, PHP_URL_PATH);

        if($path === '/user/login'){
            $this->view('login.php');
        }
    }

    public function showRegisterForm() {
        $requestUri = $_SERVER['REQUEST_URI'];

        // Remove parâmetros da query string (se houver)
        $path = parse_url($requestUri, PHP_URL_PATH);

        // Verifica se o caminho corresponde a "/customer/register"
        if ($path === '/customer/register') {
            $this->view('customer_register.html');
        } else if($path === '/restaurant/register') {
            $this->view('restaurant_register.html');
        }
    }
}
