<?php
use Connection\database\Database;
use Coursemanager\CourseManager;
use Tagmanager\TagManager;
use Categorymanager\CategoryManager;

require_once('../Model/CourseManager.php');
require_once('../Model/Database.php');
require_once('../Model/TagManager.php');
require_once('../Model/CategoryManager.php');

session_start();

try {
    $database = new Database();
    $db = $database->getConnection();
    $categorie = new CategoryManager($db);
    $categories = $categorie->getAllCategories();
    $tagManager = new TagManager($db);
    $tags = $tagManager->getAllTags();
} catch (Exception $e) {
    $_SESSION['error'] = "Erreur de connexion à la base de données: " . $e->getMessage();
    error_log("Database connection error: " . $e->getMessage());
    $categories = [];
    $tags = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (empty($_POST['title']) || empty($_POST['description']) || 
        empty($_POST['category'])) {
        $_SESSION['error'] = "Tous les champs obligatoires doivent être remplis.";
        header('Location: add_cours_teacher.php');
        exit;
    }

    // Validate content based on type
    $content_type = $_POST['content_type'];
    if ($content_type === 'video') {
        $content = $_POST['video_url'];
    } else {
        $content = $_POST['document_url'];
    }

    if (empty($content)) {
        $_SESSION['error'] = "Le contenu du cours est requis.";
        header('Location: add_cours_teacher.php');
        exit;
    }

    try {
        $courseManager = new CourseManager($db);
        $courseData = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description']),
            'content_type' => $content_type,
            'content' => trim($content),
            'category' => $_POST['category'],
            'teacher_id' => $_SESSION['user_id']
        ];

        $course_id = $courseManager->addCourse($courseData);

        if (isset($_POST['tags']) && is_array($_POST['tags'])) {
            foreach ($_POST['tags'] as $tag_id) {
                $stmt = $db->prepare("INSERT INTO course_tags (course_id, tag_id) VALUES (?, ?)");
                $stmt->execute([$course_id, $tag_id]);
            }
        }

        $_SESSION['success'] = "Le cours a été créé avec succès.";
        header('Location: Course_Management_teacher.php');
        exit;

    } catch (Exception $e) {
        error_log("Course creation error: " . $e->getMessage());
        $_SESSION['error'] = "Une erreur est survenue: " . $e->getMessage();
        header('Location: add_cours_teacher.php');
        exit;
    }
}

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
