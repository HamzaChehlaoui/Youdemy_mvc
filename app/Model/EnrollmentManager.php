<?php
namespace EnrollmentManager;
use Connection\database\Database;
use PDOException;
use PDO;
require_once('../Model/Database.php');
require_once('../Controller/Detail_cours.php');
class EnrollmentManager
{
    private $db;
    private $conn;
    private $userId;
    private $courseId;

    public function __construct()
    {
        session_start();
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        $this->userId = $_SESSION['user_id'] ?? null;
        $this->courseId = $_GET['id'] ?? null;
    }

    public function checkUserLogin()
    {
        if (!$this->userId) {
            $_SESSION['error'] = "Veuillez vous connecter pour vous inscrire à un cours.";
            header('Location: login.php');
            exit();
        }
    }

    public function checkCourseId()
    {
        if (!$this->courseId) {
            $_SESSION['error'] = "ID du cours manquant.";
            header('Location: index.php');
            exit();
        }
    }

    public function handleFormSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Check if already enrolled
                $checkStmt = $this->conn->prepare("SELECT id FROM enrollments WHERE student_id = :student_id AND course_id = :course_id");
                $checkStmt->execute([':student_id' => $this->userId, ':course_id' => $this->courseId]);
                
                if ($checkStmt->rowCount() > 0) {
                    $_SESSION['error'] = "Vous êtes déjà inscrit à ce cours.";
                    header('Location: index.php?id=' . $this->courseId);
                    exit();
                }

                // Insert new enrollment
                $stmt = $this->conn->prepare("
                    INSERT INTO enrollments (student_id, course_id, status) 
                    VALUES (:student_id, :course_id, :status)
                ");

                $stmt->execute([
                    ':student_id' => $this->userId,
                    ':course_id' => $this->courseId,
                    ':status' => 'active'
                ]);
                $contentStmt = $this->conn->prepare("SELECT content_url FROM courses WHERE id_courses = :course_id");

                $contentStmt->execute([':course_id' => $this->courseId]);

                $content = $contentStmt->fetch(PDO::FETCH_ASSOC);

                if ($content) {
                    $_SESSION['success'] = "Inscription au cours réussie!";
                    
                    header("Location: " . $content['content_url']);
                    exit();
                
        } else {
            $_SESSION['error'] = "La ressource du cours n'a pas été trouvée.";
            header('Location: index.php'); 

            } }catch (PDOException $e) {
                $_SESSION['error'] = "Erreur lors de l'inscription au cours: " . $e->getMessage();
                header('Location: index.php?id=' . $this->courseId);
                exit();
            }
        }
    }
}

?>
