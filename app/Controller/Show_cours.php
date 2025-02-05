<?php
use Connection\database\Database;
use Categorymanager\CategoryManager;
use Coursemanager\CourseManager;
require_once('../Model/Database.php');
require_once('../Model/CategoryManager.php');
require_once('../Model/CourseManager.php');

    $database = new Database();
    $db = $database->getConnection();

// Get filter parameters
$categoryId = $_GET['category'] ?? null;
$searchQuery = $_GET['search'] ?? '';
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$itemsPerPage = 3; // Number of courses per page
$Categorymanager= new CategoryManager($db);
$categories=$Categorymanager->getAllCategories();

// Get categories and courses
$coursess = new CourseManager($db);
$result = $coursess->getCoursesWithPagination($categoryId, $searchQuery, $currentPage, $itemsPerPage);
$courses = $result['courses'];
$totalPages = $result['totalPages'];?>