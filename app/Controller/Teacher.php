<?php
use Config\Database;
use Users\Admin;

require_once('/laragon/www/youdemy_mvc/vendor/autoload.php');
$database = new Database();
$db = $database->getConnection();
$teacher = new Admin($db);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $userId = $_POST['user_id'] ?? '';
    
    switch($action) {
        case 'activate':
            $teacher->updateStatus($userId, 'active');
            break;
        case 'suspend':
            $teacher->updateStatus($userId, 'suspended');
            break;
        case 'delete':
            $teacher->deleteTeacher($userId);
            break;
    }
    
    // Redirect back to the same page to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}