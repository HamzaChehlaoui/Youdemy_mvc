<?php
namespace App\Controllers;

use App\Core\Controller;
use Config\Database;
use App\Models\CourseManager;
use App\Models\CategoryManager;

class CourseController extends Controller {
    private $courseManager;
    private $categoryManager;
    
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->courseManager = new CourseManager($db);
        $this->categoryManager = new CategoryManager($db);
    }

    public function view($view, $data = []) {
        extract($data);
        ob_start();
        require_once __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();
        require_once __DIR__ . "/../Views/layouts/main.php";
    }

    public function index() {
        $categoryId = $_GET['category'] ?? null;
        $searchQuery = $_GET['search'] ?? '';
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $itemsPerPage = 3;

        $result = $this->courseManager->getCoursesWithPagination(
            $categoryId, 
            $searchQuery, 
            $currentPage, 
            $itemsPerPage
        );

        $this->view('courses/index', [
            'title' => 'list cours',
            'courses' => $result['courses'],
            'totalPages' => $result['totalPages'],
            'categories' => $this->categoryManager->getAllCategories(),
            'currentPage' => $currentPage,
            'categoryId' => $categoryId,
            'searchQuery' => $searchQuery
        ]);
    }

    public function show($id) {
        $course = $this->courseManager->getCourseDetails($id);
        
        if (!$course) {
            $_SESSION['error'] = "Course not found";
            header('Location: /courses');
            exit();
        }

        $this->view('courses/detail', [
            'title' => $course['title'],
            'course' => $course
        ]);
    }

    public function addCourse() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
            $_SESSION['error'] = "Unauthorized access";
            header('Location: /courses');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->courseManager->addCourse($_POST);
        }

        $this->view('courses/add', [
            'title' => 'Add New Course',
            'categories' => $this->categoryManager->getAllCategories()
        ]);
    }

    public function getCourseDetails($id) {
        return $this->courseManager->getCourseDetails($id);
    }
}
