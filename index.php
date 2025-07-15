<?php

// Include necessary files
require_once 'router.php'; 


// route files
require_once 'routes/userRoutes.php';

// router instance
$router = new Router();
    
    // Mount API routes
    $router->mount('api/users', 'routes/userRoutes.php');
    
    // Add base route
    $router->addRoute('GET', '/', function() {
        echo "Welcome to the API!";
    });
    
    // Handle request
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $router->handleRequest($requestUri, $requestMethod);

?>
