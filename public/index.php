<?php
// Load Composer Autoloader
require_once '/laragon/www/youdemy_mvc/vendor/autoload.php';

// Include the routing file
require_once '../routes/web.php';

// Get the request URI
$request = $_SERVER['REQUEST_URI'];

// Remove any query parameters from the URL
$request = strtok($request, '?');

// Call the function to define the route
defineRoutes($request);
