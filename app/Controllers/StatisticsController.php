<?php
namespace App\Controllers;

use Config\Database;
use App\Models\StatisticsManager;

class StatisticsController {
    private $stats;
    
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->stats = new StatisticsManager($db);
    }
    
    public function getDashboardStatistics() {
        return [
            'categoryDistribution' => $this->stats->getCoursesByCategory(),
            'topTeachers' => $this->stats->getTopTeachers(),
            'popularCourse' => $this->stats->getMostPopularCourse()
        ];
    }

    public function getTeacherStatistics($teacherId) {
        return [
            'totalStudents' => $this->stats->getTotalStudents($teacherId),
            'activeCourses' => $this->stats->getActiveCourses($teacherId)
        ];
    }

    public function getCourseStatistics() {
        return [
            'categoryDistribution' => $this->stats->getCoursesByCategory(),
            'mostPopular' => $this->stats->getMostPopularCourse()
        ];
    }

    public function getTeacherLeaderboard($limit = 3) {
        return $this->stats->getTopTeachers($limit);
    }
}
