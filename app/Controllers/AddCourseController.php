<?php
namespace App\Controllers;
use Config\Database;
use App\Models\CourseManager;
use App\Models\CategoryManager;
use App\Models\TagManager;

class AddCourseController {
    private $courseManager;
    private $categoryManager;
    private $tagManager;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->courseManager = new CourseManager($db);
        $this->categoryManager = new CategoryManager($db);
        $this->tagManager = new TagManager($db);
    }

    public function index() {
        return [
            'categories' => $this->categoryManager->getAllCategories(),
            'tags' => $this->tagManager->getAllTags()
        ];
    }

    public function store() {
        if (!$this->validateInput()) {
            return false;
        }

        $courseData = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description']),
            'content_type' => $_POST['content_type'],
            'content' => $_POST['content_type'] === 'video' ? $_POST['video_url'] : $_POST['document_url'],
            'category' => $_POST['category'],
            'teacher_id' => $_SESSION['user_id']
        ];

        try {
            $courseId = $this->courseManager->addCourse($courseData);
            $this->handleTags($courseId);
            $_SESSION['success'] = "Le cours a été créé avec succès.";
            return true;
        } catch (\Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue: " . $e->getMessage();
            return false;
        }
    }

    private function validateInput() {
        if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['category'])) {
            $_SESSION['error'] = "Tous les champs obligatoires doivent être remplis.";
            return false;
        }
        return true;
    }

    private function handleTags($courseId) {
        if (isset($_POST['tags']) && is_array($_POST['tags'])) {
            $this->courseManager->addCourse($courseId, $_POST['tags']);
        }
    }
}
