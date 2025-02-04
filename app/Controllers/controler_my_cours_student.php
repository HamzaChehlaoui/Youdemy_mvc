<?php
use Connection\database\Database;
use Users\Student;
require_once('../Model/Database.php');
require_once('../Model/User.php');
session_start();

// Uncomment this block to check if the user is logged in as a student
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
//     header('Location: login.php');
//     exit();
// }



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
