<?php
class Router {
    private $routes = [];

    public function addRoute($path, $controller, $action) {
        $this->routes[$path] = ['controller' => $controller, 'action' => $action];
    }

    public function handleRequest() {
        $path = $_GET['route'] ?? 'home';
        if (isset($this->routes[$path])) {
            $route = $this->routes[$path];
            $controllerName = $route['controller'];
            $action = $route['action'];

            $controller = new $controllerName();
            $controller->$action();
        } else {
            // 404
            echo "404 Not Found";
        }
    }
}
?>