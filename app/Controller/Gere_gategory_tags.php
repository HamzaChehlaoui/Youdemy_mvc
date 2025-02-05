<?php
use Connection\database\Database;
use Categorymanager\CategoryManager;
use Tagmanager\TagManager;
use Coursemanager\CourseManager;
use Statistic\StatisticsManager;
require_once "../Model/Database.php";
require_once "../Model/CategoryManager.php";
require_once "../Model/TagManager.php";
require_once "../Model/CourseManager.php";
require_once "../Model/Statistics.php";

$database = new Database();
$db = $database->getConnection();
$categoryManager = new CategoryManager($db);
$tagManager = new TagManager($db);
$courseManager = new CourseManager($db);
$statsManager = new StatisticsManager($db);

$coursesByCategory = $statsManager->getCoursesByCategory();
$topTeachers = $statsManager->getTopTeachers();
$mostPopularCourse = $statsManager->getMostPopularCourse();

$categories = $categoryManager->getAllCategories();
$tags = $tagManager->getAllTags();
$courses = $courseManager->getCourses(
    $_GET['category_id'] ?? null,
    $_GET['tag_id'] ?? null
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'addTag':
                if (!empty($_POST['name'])) {
                    $tagManager->addTag($_POST['name']);
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
                break;
            
            case 'deleteTag':
                if (!empty($_POST['id'])) {
                    $tagManager->deleteTag($_POST['id']);
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
                break;
            
            case 'addCategory':
                if (!empty($_POST['name'])) {
                    $categoryManager->addCategory($_POST['name']);
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
                break;
            
            case 'deleteCategory':
                if (!empty($_POST['id'])) {
                    $categoryManager->deleteCategory($_POST['id']);
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
                break;
            
            case 'deleteCourse':
                if (!empty($_POST['id'])) {
                    $courseManager->deleteCourse($_POST['id']);
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
                break;
        }
    }
}
?>
