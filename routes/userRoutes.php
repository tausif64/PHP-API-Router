<?php

return function($router) { 
    $router->addRoute('POST', 'login', function() { 
        echo "User  logout endpoint";
    });

    $router->addRoute('POST', 'logout', function() {
        echo "User  logout endpoint";
    });

    $router->addRoute('PUT', 'update/:id', function($id) {
        echo "Update user ID: $id";
    });

    $router->addRoute('DELETE', 'update/:id', function($id) {
        echo "Delete user ID: $id";
    });
};
?>
