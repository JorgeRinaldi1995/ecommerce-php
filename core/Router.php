<?php

namespace Core;

class Router {
    protected array $routes = [];

    public function get(string $uri, string $controllerMethod) {
        $this->routes['GET'][$uri] = $controllerMethod;
    }

    public function post(string $uri, string $controllerMethod) {
        $this->routes['POST'][$uri] = $controllerMethod;
    }

    public function dispatch(string $uri) {
        $uri = parse_url($uri, PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$uri])) {
            [$controller, $method] = explode('@', $this->routes[$method][$uri]);
            $controller = "App\\Controllers\\$controller";
            (new $controller)->$method();
        } else {
            http_response_code(404);
            echo "Página não encontrada!";
        }
    }
}
