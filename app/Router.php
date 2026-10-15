<?php

namespace App;

class Router
{
    protected static array $routes = [];

    public static function get(string $uri, $action): void
    {
        self::addRoute('GET', $uri, $action);
    }

    public static function post(string $uri, $action): void
    {
        self::addRoute('POST', $uri, $action);
    }

    protected static function addRoute(string $method, string $uri, $action): void
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => '/' . trim($uri, '/'),
            'action' => $action
        ];
    }

    public static function dispatch(string $method, string $uri)
    {
        $uri = '/' . trim(explode('?', $uri)[0], '/');

        foreach (self::$routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            // Convert /products/{id} to regex
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                if (is_callable($route['action'])) {
                    return call_user_func_array($route['action'], $params);
                }

                if (is_array($route['action'])) {
                    [$controllerClass, $methodName] = $route['action'];
                    $controller = new $controllerClass();
                    return call_user_func_array([$controller, $methodName], $params);
                }
            }
        }

        // Fallback 404
        http_response_code(404);
        return view('home'); // or redirect home
    }
}
