<?php 
use EnrollmentManager\EnrollmentManager;
require_once('/laragon/www/youdemy_mvc/vendor/autoload.php');
$enrollmentManager = new EnrollmentManager();
$enrollmentManager->checkUserLogin();
$enrollmentManager->checkCourseId();
$enrollmentManager->handleFormSubmission();

?>