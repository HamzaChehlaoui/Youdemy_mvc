<?php

namespace App\Core;

class Router
{
    protected array $routes = [];
    protected array $middlewares = [];
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }

    public function group(array $options, callable $callback)
    {
        $this->middlewares[] = $options['middleware'] ?? null;
        $callback($this);
        array_pop($this->middlewares);
    }

    protected function addRoute($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'middleware' => end($this->middlewares)
        ];
    }

    public function resolve()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['path'] === $path && $route['method'] === $method) {
                if ($route['middleware']) {
                    // Handle middleware here
                    $this->handleMiddleware($route['middleware']);
                }
                return $this->handleCallback($route['callback']);
            }
        }

        http_response_code(404);
        return "404 Not Found";
    }

    protected function handleCallback($callback)
    {
        if (is_string($callback)) {
            list($controller, $method) = explode('@', $callback);
            $controller = "App\\Controllers\\$controller";
            $instance = new $controller();
            return $instance->$method();
        }
        return call_user_func($callback);
    }

    protected function handleMiddleware($middleware)
    {
        // Implement middleware handling logic
    }
}
