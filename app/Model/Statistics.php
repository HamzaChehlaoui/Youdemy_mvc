<?php 
namespace Statistic;
use PDO;
class StatisticsManager {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getCoursesByCategory() {
        $query = "SELECT c.name as category_name, COUNT(co.id_courses) as course_count
                 FROM categories c
                 LEFT JOIN courses co ON c.id_categories = co.category_id
                 GROUP BY c.id_categories, c.name
                 ORDER BY course_count DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopTeachers($limit = 3) {
        $query = "SELECT u.username, u.id_user,
                    COUNT(DISTINCT c.id_courses) as course_count,
                    COUNT(DISTINCT e.student_id) as student_count
                FROM users u
                JOIN courses c ON u.id_user = c.teacher_id
                LEFT JOIN enrollments e ON c.id_courses = e.course_id
                WHERE u.role = 'teacher'
                GROUP BY u.id_user, u.username
                ORDER BY student_count DESC
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMostPopularCourse() {
        $query = "SELECT c.title, c.id_courses,
                    u.username as teacher_name,
                    COUNT(e.student_id) as student_count,
                    (SELECT COUNT(*) FROM enrollments) as total_enrollments
                 FROM courses c
                 JOIN users u ON c.teacher_id = u.id_user
                 LEFT JOIN enrollments e ON c.id_courses = e.course_id
                 GROUP BY c.id_courses, c.title, u.username
                 ORDER BY student_count DESC
                 LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getTotalStudents($id) {
        $query = "select count(DISTINCT student_id) as total from enrollments e,courses c where e.course_id=c.id_courses and c.teacher_id=:id;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(["id"=>$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getActiveCourses($id) {
        $query = "SELECT COUNT(*) as total FROM courses WHERE status = 'published' AND teacher_id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(["id"=>$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}?>