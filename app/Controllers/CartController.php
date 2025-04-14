<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Cart;

class CartController extends Controller {
    public function index() {
        $cart = new Cart();
        $items = $cart->getItems();
        $this->view('cart', ['items' => $items]);
    }

    public function add() {
        $productId = (int) ($_POST['product_id'] ?? 0);
        $product = \App\Models\Product::find($productId);
    
        if ($product) {
            $cart = $_SESSION['cart'] ?? [];
    
            // Se o produto já estiver no carrinho, incrementa a quantidade
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += 1;
            } else {
                $cart[$productId] = [
                    'product' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1
                ];
            }
    
            $_SESSION['cart'] = $cart;
        }
    
        header('Location: /cart');
        exit;
    }
    public function remove() {
        $productId = (int) ($_POST['product_id'] ?? 0);
    
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    
        header('Location: /cart');
        exit;
    }

    public function checkout() {
        if (!empty($_SESSION['cart'])) {
            $_SESSION['cart'] = []; // Simula finalização da compra
            echo "Compra finalizada com sucesso!";
        } else {
            echo "Carrinho está vazio!";
        }
    }
}
