<?php
namespace App\Controllers;

use Config\Database;
use App\Models\Admin;

class TeacherController {
    private $teacher;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->teacher = new Admin($this->db);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $userId = $_POST['user_id'] ?? '';
            
            switch($action) {
                case 'activate':
                    $this->teacher->updateStatus($userId, 'active');
                    break;
                case 'suspend':
                    $this->teacher->updateStatus($userId, 'suspended');
                    break;
                case 'delete':
                    $this->teacher->deleteTeacher($userId);
                    break;
            }
            
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}
