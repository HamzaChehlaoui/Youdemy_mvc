<?php
namespace App\Controllers;

use Config\Database;
use App\Models\User;

class AuthController {
    private $user;
    
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
    }

    public function login($email, $password) {
        $this->user->setEmail($email);
        $this->user->setPassword($password);
        return $this->user->login();
    }

    public function register($userData) {
        $this->user->setUsername($userData['username']);
        $this->user->setEmail($userData['email']);
        $this->user->setPassword($userData['password']);
        $this->user->setRole($userData['role']);
        return $this->user->register();
    }
}
