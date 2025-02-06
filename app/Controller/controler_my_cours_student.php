<?php
use Config\Database;
use Users\Student;
// require_once('../config/Database.php');
// require_once('../Model/User.php');
require_once('/laragon/www/youdemy_mvc/vendor/autoload.php');
session_start();



// Database connection
$database = new Database();
$db=$database->getConnection();
$student = new Student($db);

// Get courses for each status
$activeCourses = $student->getActiveCourses($_SESSION['user_id']);
$completedCourses = $student->getCompletedCourses($_SESSION['user_id']);
$pendingCourses = $student->getPendingCourses($_SESSION['user_id']);

// Get active tab
$currentTab = $_GET['tab'] ?? 'active';

?>
