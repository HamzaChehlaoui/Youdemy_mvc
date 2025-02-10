<?php
namespace App\Controllers;

use Config\Database;
use App\Models\CategoryManager;
use App\Models\TagManager;
use App\Models\CourseManager;
use App\Models\StatisticsManager;

class CategoryTagController {
    private $categoryManager;
    private $tagManager;
    private $courseManager;
    private $statsManager;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->categoryManager = new CategoryManager($db);
        $this->tagManager = new TagManager($db);
        $this->courseManager = new CourseManager($db);
        $this->statsManager = new StatisticsManager($db);
    }

    public function index() {
        return [
            'coursesByCategory' => $this->statsManager->getCoursesByCategory(),
            'topTeachers' => $this->statsManager->getTopTeachers(),
            'mostPopularCourse' => $this->statsManager->getMostPopularCourse(),
            'categories' => $this->categoryManager->getAllCategories(),
            'tags' => $this->tagManager->getAllTags(),
            'courses' => $this->courseManager->getCourses(
                $_GET['category_id'] ?? null,
                $_GET['tag_id'] ?? null
            )
        ];
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action'])) {
            return false;
        }

        switch ($_POST['action']) {
            case 'addTag':
                return $this->addTag();
            case 'deleteTag':
                return $this->deleteTag();
            case 'addCategory':
                return $this->addCategory();
            case 'deleteCategory':
                return $this->deleteCategory();
            case 'deleteCourse':
                return $this->deleteCourse();
            default:
                return false;
        }
    }

    private function addTag() {
        if (!empty($_POST['name'])) {
            $this->tagManager->addTag($_POST['name']);
            $this->redirect();
            return true;
        }
        return false;
    }

    private function deleteTag() {
        if (!empty($_POST['id'])) {
            $this->tagManager->deleteTag($_POST['id']);
            $this->redirect();
            return true;
        }
        return false;
    }

    private function addCategory() {
        if (!empty($_POST['name'])) {
            $this->categoryManager->addCategory($_POST['name']);
            $this->redirect();
            return true;
        }
        return false;
    }

    private function deleteCategory() {
        if (!empty($_POST['id'])) {
            $this->categoryManager->deleteCategory($_POST['id']);
            $this->redirect();
            return true;
        }
        return false;
    }

    private function deleteCourse() {
        if (!empty($_POST['id'])) {
            $this->courseManager->deleteCourse($_POST['id']);
            $this->redirect();
            return true;
        }
        return false;
    }

    private function redirect() {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
