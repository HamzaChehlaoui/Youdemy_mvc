<?php
use Connection\database\Database;
require_once('../Model/CourseManager.php');
require_once('../Model/Database.php');

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
    public function getAllCoursesTeacher($id){
        $query = "SELECT 
                    c.*, u.username as teacher_name, 
                    cat.name as category_name,
                    (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.id_courses) as student_count
                FROM 
                    " . $this->table . " c
                    LEFT JOIN users u ON c.teacher_id = u.id_user
                    LEFT JOIN categories cat ON c.category_id = cat.id_categories
                    WHERE teacher_id=:id 
                ORDER BY 
                    c.id_courses DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(["id"=>$id]);
        return $stmt;
    }
}

$database = new Database();
$db = $database->getConnection();
$course = new Course($db);
?>
