<?php
use Config\Database;
use coursteacher\Courses;
require_once('/laragon/www/youdemy_mvc/vendor/autoload.php');
$database = new Database();
$db = $database->getConnection();
$course = new Courses($db);
?>
