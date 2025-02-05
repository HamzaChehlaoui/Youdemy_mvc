<?php

use Connection\database\Database;
use Coursemanager\CourseManager;
require_once('../Model/Database.php');
require_once('../Model/CourseManager.php');
$database =new Database();
$db =$database->getConnection();
$controller = new CourseManager($db);
$courseId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$courseDetails = $controller->getCourseDetails($courseId);

if (isset($courseDetails['error'])) {
    header('Location: courses.php');
    exit();
}
