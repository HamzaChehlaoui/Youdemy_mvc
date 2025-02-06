<?php

use Config\Database;
use Coursemanager\CourseManager;
// require_once('../config/Database.php');
// require_once('../Model/CourseManager.php');
require_once('/laragon/www/youdemy_mvc/vendor/autoload.php');
$database =new Database();
$db =$database->getConnection();
$controller = new CourseManager($db);
$courseId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$courseDetails = $controller->getCourseDetails($courseId);

if (isset($courseDetails['error'])) {
    header('Location: courses.php');
    exit();
}
