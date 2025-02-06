<?php
use Config\Database;
use coursteacher\Course;
require_once('/laragon/www/youdemy_mvc/vendor/autoload.php');


$database = new Database();
$db = $database->getConnection();
$course = new Course($db);
?>
