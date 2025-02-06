<?php

use App\Controller\Show_cours;
use App\Controller\AdminController;

function defineRoutes($request)
{
    $routes = [
        '/' => 'Show_cours@index',
        '/index' => 'Show_cours@index',
        '/courses' => 'Show_cours@showCourses',
        '/admin' => 'AdminController@dashboard',
    ];

    if (array_key_exists($request, $routes)) {
        // Split the Controller and Method using @
        list($controllerName, $methodName) = explode('@', $routes[$request]);

        // Include the Controller file
        require_once "app/Controller/{$controllerName}.php";

        // Create an instance of the Controller
        $controller = new $controllerName();

        // Check if the method exists
        if (method_exists($controller, $methodName)) {
            // Call the method of the Controller
            $controller->$methodName();
        } else {
            echo "Method {$methodName} not found in controller {$controllerName}.";
        }
    } else {
        // Display 404 if the route does not exist
        echo "404 Page not found!";
    }
}
