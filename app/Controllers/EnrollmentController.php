<?php
namespace App\Controllers;

use App\Models\EnrollmentManager;

class EnrollmentController {
    private $enrollmentManager;

    public function __construct() {
        $this->enrollmentManager = new EnrollmentManager();
    }

    public function handleEnrollment() {
        $this->enrollmentManager->checkUserLogin();
        $this->enrollmentManager->checkCourseId();
        return $this->enrollmentManager->handleFormSubmission();
    }
}
