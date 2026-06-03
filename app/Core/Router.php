<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $route, array $action): void
    {
        $this->routes['GET'][$route] = $action;
    }

    public function post(string $route, array $action): void
    {
        $this->routes['POST'][$route] = $action;
    }

    public function dispatch(string $method, string $route): void
    {
        $route = trim($route, '/');
        $route = $route === '' ? 'students' : $route;

        if (!isset($this->routes[$method][$route])) {
            http_response_code(404);
            echo 'Ruta no encontrada.';
            return;
        }

        [$controllerClass, $controllerMethod] = $this->routes[$method][$route];
        $controller = new $controllerClass();
        $controller->{$controllerMethod}();
    }
}
