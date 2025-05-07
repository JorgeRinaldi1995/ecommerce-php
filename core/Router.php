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
        $uriPath = parse_url($uri, PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
    
        foreach ($this->routes[$method] ?? [] as $route => $controllerMethod) {
            $routePattern = preg_replace('/\{[^\/]+\}/', '([^\/]+)', $route);
            $routePattern = "#^" . $routePattern . "$#";
    
            if (preg_match($routePattern, $uriPath, $matches)) {
                array_shift($matches); // Remove o match completo
                [$controller, $methodName] = explode('@', $controllerMethod);
                $controller = "App\\Controllers\\$controller";
    
                call_user_func_array([new $controller, $methodName], $matches);
                return;
            }
        }
    
        http_response_code(404);
        echo "Página não encontrada!";
    }
    
}
