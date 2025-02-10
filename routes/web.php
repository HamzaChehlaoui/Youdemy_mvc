<?php

use App\Core\Router;

// Initialize Router
$router = Router::getInstance();

// Public routes
$router->get('/', 'CourseController@index');
$router->get('/courses', 'CourseController@index');
$router->get('/course/{id}', 'CourseController@show');
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// Protected routes (requires authentication)
$router->group(['middleware' => 'auth'], function($router) {
    $router->get('/course/add', 'AddCourseController@index');
    $router->post('/course/store', 'AddCourseController@store');
});
