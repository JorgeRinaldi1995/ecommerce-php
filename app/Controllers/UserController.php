<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Core\Middleware\AuthMiddleware;

class UserController extends Controller {
    public function show($id) {
        $auth = AuthMiddleware::handle();

        if ($auth->uid != $id && User::findById($auth->uid)['role'] != 0) {
            http_response_code(403);
            echo json_encode(['error' => 'Acesso não autorizado']);
            return;
        }

        $user = User::findById($id);
        if ($user) {
            header('Content-Type: application/json');
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuário não encontrado']);
        }
    }
}