<?php

namespace Core;

class Controller {

    protected function view(string $view, array $data = []) {
        extract($data);

        // Se já vier com extensão, usa como está
        if (str_ends_with($view, '.php') || str_ends_with($view, '.html')) {
            $filePath = __DIR__ . '/../app/Views/' . $view;
        } else {
            // Tenta primeiro o .php
            $filePath = __DIR__ . '/../app/Views/' . $view . '.php';
            if (!file_exists($filePath)) {
                // Se não existir, tenta o .html
                $filePath = __DIR__ . '/../app/Views/' . $view . '.html';
            }
        }

        if (file_exists($filePath)) {
            require_once $filePath;
        } else {
            http_response_code(404);
            echo "View '{$view}' não encontrada.";
        }
    }
}