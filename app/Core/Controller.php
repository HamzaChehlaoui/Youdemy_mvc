<?php
namespace App\Core;

abstract class Controller {
    protected $middleware = [];

    protected function view($view, $data = []) {
        return View::renderWithLayout($view, $data);
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected function redirect($path) {
        header("Location: $path");
        exit();
    }

    protected function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    protected function isTeacher() {
        return $this->isAuthenticated() && $_SESSION['role'] === 'teacher';
    }

    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            $_SESSION['error'] = "Please login to continue";
            $this->redirect('/login');
        }
    }

    protected function requireTeacher() {
        if (!$this->isTeacher()) {
            $_SESSION['error'] = "Unauthorized access";
            $this->redirect('/courses');
        }
    }

    protected function middleware($middleware) {
        $this->middleware[] = $middleware;
        return $this;
    }

    public function hasMiddleware($middleware) {
        return in_array($middleware, $this->middleware);
    }

    protected function validate($data, $rules) {
        $errors = [];
        foreach ($rules as $field => $rule) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }
        return $errors;
    }
}
