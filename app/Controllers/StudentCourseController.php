<?php
namespace App\Controllers;

use App\Models\Student;
use Config\Database;

class StudentCourseController {
    private $student;
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->student = new Student($db);
    }

    public function getMyCourses($userId) {
        return [
            'active' => $this->student->getActiveCourses($userId),
            'completed' => $this->student->getCompletedCourses($userId),
            'pending' => $this->student->getPendingCourses($userId),
            'currentTab' => $_GET['tab'] ?? 'active'
        ];
    }
}
