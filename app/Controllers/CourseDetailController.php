<?php
namespace App\Controllers;

use App\Models\CourseManager;
use Config\Database;
class CourseDetailController {
    private $courseManager;

    public function __construct() {
        $database = new Database();
        $this->courseManager = new CourseManager($database->getConnection());
    }

    public function show($courseId) {
        $courseDetails = $this->courseManager->getCourseDetails($courseId);
        
        if (isset($courseDetails['error'])) {
            header('Location: /courses');
            exit();
        }

        return $courseDetails;
    }
}
