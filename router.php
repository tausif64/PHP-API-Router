<?php
class Router {
    private $routes = [];
    private $currentPrefix = '';

    public function addRoute($method, $uri, $callback) {
        $this->routes[$method][$this->currentPrefix . ltrim($uri, '/')] = $callback;
    }

    public function mount($prefix, $routeFile) {
        $previousPrefix = $this->currentPrefix;
        $this->currentPrefix .= rtrim($prefix, '/') . '/';
        
        $routeDefiner = require $routeFile;
        $routeDefiner($this);
        
        $this->currentPrefix = $previousPrefix;
    }

    public function handleRequest($uri, $method) {
        $uri = ltrim(parse_url($uri, PHP_URL_PATH), '/');
        
        if (!isset($this->routes[$method])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        foreach ($this->routes[$method] as $route => $callback) {
            if ($route === $uri) {
                call_user_func($callback);
                return;
            }
            
            $pattern = preg_replace('/\/:(\w+)/', '/(?<$1>[^/]+)', $route);
            $regex = "#^$pattern$#";
            
            if (preg_match($regex, $uri, $matches)) {
                $params = array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));
                call_user_func_array($callback, $params);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
?>
