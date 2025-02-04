<?php 
use EnrollmentManager\EnrollmentManager;
require_once('../Model/EnrollmentManager.php');

$enrollmentManager = new EnrollmentManager();
$enrollmentManager->checkUserLogin();
$enrollmentManager->checkCourseId();
$enrollmentManager->handleFormSubmission();

?>