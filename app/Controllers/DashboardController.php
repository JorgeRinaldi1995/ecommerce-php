<?php

namespace App\Controllers;

use Core\Middleware\AuthMiddleware;
use App\Models\User;
use Core\Controller;

class DashboardController extends Controller {
    public function index() {
        $user = AuthMiddleware::requireRole([0, 2]); // admin e seller
        $this->view('dashboard', ['user' => $user]);
    }
}