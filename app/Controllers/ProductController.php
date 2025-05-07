<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Product;
use Core\Middleware\AuthMiddleware;

class ProductController extends Controller {
    public function index(){
        $products = Product::all();
        $this->view('products', ['products' => $products]);
    }

    
}