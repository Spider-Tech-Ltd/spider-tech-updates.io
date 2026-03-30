<?php
class Router {
    private $routes = [];

    public function addRoute($path, $controller, $action) {
        $this->routes[$path] = ['controller' => $controller, 'action' => $action];
    }

    public function handleRequest() {
        $url = $_GET['url'] ?? 'home';
        $url = rtrim($url, '/');

        // Remove query string if present
        if (strpos($url, '?') !== false) {
            $url = substr($url, 0, strpos($url, '?'));
        }

        if (isset($this->routes[$url])) {
            $route = $this->routes[$url];
            $controllerName = $route['controller'];
            $action = $route['action'];

            $controller = new $controllerName();
            $controller->$action();
        } else {
            // Check for legacy ?route= format just in case
            $routeParam = $_GET['route'] ?? null;
            if ($routeParam && isset($this->routes[$routeParam])) {
                $route = $this->routes[$routeParam];
                $controllerName = $route['controller'];
                $action = $route['action'];
                $controller = new $controllerName();
                $controller->$action();
                return;
            }
            // 404
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found - Requested URL: " . htmlspecialchars($url);
        }
    }
}
?>