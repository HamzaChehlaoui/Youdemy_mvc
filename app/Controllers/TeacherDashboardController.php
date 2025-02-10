<?php
namespace App\Controllers;

use App\Models\Courses;
use Config\Database;
class TeacherDashboardController {
    private $courses;

    public function __construct() {
        $database = new Database();
        $this->courses = new Courses($database->getConnection());
    }

    public function getDashboardData() {
        return [
            'courses' => $this->courses->getTeacherCourses($_SESSION['user_id']),
            'stats' => $this->courses->getTeacherStats($_SESSION['user_id'])
        ];
    }
}
