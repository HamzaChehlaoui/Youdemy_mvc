<?php
// delete_course.php
session_start();
// config/Database.php
class Database {
    private $host = "localhost";
    private $db_name = "youdemy";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
        return $this->conn;
    }
}

// models/Course.php
class Course {
    private $conn;
    private $table = "courses";

    public $id_courses;
    public $title;
    public $description;
    public $content_type;
    public $content_url;
    public $teacher_id;
    public $category_id;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCourses() {
        $query = "SELECT 
                    c.*, u.username as teacher_name, 
                    cat.name as category_name,
                    (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.id_courses) as student_count
                FROM 
                    " . $this->table . " c
                    LEFT JOIN users u ON c.teacher_id = u.id_user
                    LEFT JOIN categories cat ON c.category_id = cat.id_categories
                ORDER BY 
                    c.id_courses DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getCourseTags($course_id) {
        $query = "SELECT t.name 
                FROM tags t 
                INNER JOIN course_tags ct ON t.id_tags = ct.tag_id 
                WHERE ct.course_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$course_id]);
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
                SET
                    title = :title,
                    description = :description,
                    content_type = :content_type,
                    content_url = :content_url,
                    teacher_id = :teacher_id,
                    category_id = :category_id,
                    status = :status";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->content_url = htmlspecialchars(strip_tags($this->content_url));

        // Bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":content_type", $this->content_type);
        $stmt->bindParam(":content_url", $this->content_url);
        $stmt->bindParam(":teacher_id", $this->teacher_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":status", $this->status);

        return $stmt->execute();
    }

}

class CourseDeleter {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function deleteCourse($id) {
        try {
            $this->db->beginTransaction();

            // Delete course tags first (due to foreign key constraint)
            $query = "DELETE FROM course_tags WHERE course_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);

            // Delete enrollments
            $query = "DELETE FROM enrollments WHERE course_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);

            // Delete the course
            $query = "DELETE FROM courses WHERE id_courses = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $deleter = new CourseDeleter();
    if ($deleter->deleteCourse($_GET['id'])) {
        $_SESSION['message'] = "Cours supprimé avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression du cours.";
    }
}

// Redirect back to course management page
header('Location: Course_Management_teacher.php');
exit;