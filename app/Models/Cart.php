<?php

namespace App\Models;

class Cart {
    public function getItems(): array {
        // Simulação
        return [
            ['product' => 'Camisa', 'quantity' => 1, 'price' => 99.99]
        ];
    }
}
