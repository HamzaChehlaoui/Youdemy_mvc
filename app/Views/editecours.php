<?php
// edit_course.php
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

class CourseEditor {
    private $db;
    private $course;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->course = new Course($this->db);
    }

    public function getCourseData($id) {
        $query = "SELECT c.*, 
                         GROUP_CONCAT(t.id_tags) as tag_ids,
                         GROUP_CONCAT(t.name) as tag_names
                  FROM courses c
                  LEFT JOIN course_tags ct ON c.id_courses = ct.course_id
                  LEFT JOIN tags t ON ct.tag_id = t.id_tags
                  WHERE c.id_courses = ?
                  GROUP BY c.id_courses";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTags() {
        $query = "SELECT * FROM tags ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCourse($data) {
        try {
            $this->db->beginTransaction();

            // Update course table
            $query = "UPDATE courses SET 
                        title = ?,
                        description = ?,
                        content_type = ?,
                        content_url = ?,
                        category_id = ?,
                        status = ?
                     WHERE id_courses = ?";

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                $data['title'],
                $data['description'],
                $data['content_type'],
                $data['content_url'],
                $data['category_id'],
                $data['status'],
                $data['id_courses']
            ]);

            // Update course tags
            $this->updateCourseTags($data['id_courses'], $data['tags']);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    private function updateCourseTags($courseId, $tags) {
        // Remove existing tags
        $query = "DELETE FROM course_tags WHERE course_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$courseId]);

        // Add new tags
        if (!empty($tags)) {
            $query = "INSERT INTO course_tags (course_id, tag_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            foreach ($tags as $tagId) {
                $stmt->execute([$courseId, $tagId]);
            }
        }
    }
}

$editor = new CourseEditor();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_courses' => $_POST['id_courses'],
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'content_type' => $_POST['content_type'],
        'content_url' => $_POST['content_url'],
        'category_id' => $_POST['category_id'],
        'status' => $_POST['status'],
        'tags' => isset($_POST['tags']) ? $_POST['tags'] : []
    ];

    if ($editor->updateCourse($data)) {
        $message = "Cours mis à jour avec succès!";
    } else {
        $message = "Erreur lors de la mise à jour du cours.";
    }
}

$courseData = $editor->getCourseData($_GET['id']);
$categories = $editor->getCategories();
$tags = $editor->getTags();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le cours - Youdemy</title>
    <style>
        /* Styles from previous file plus: */
        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }
        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }
        .message.success {
            background: #10b981;
            color: white;
        }
        .message.error {
            background: #ef4444;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>Youdemy</h1>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2>Modifier le cours</h2>
            
            <?php if ($message): ?>
                <div class="message <?php echo strpos($message, 'Erreur') === false ? 'success' : 'error'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="id_courses" value="<?php echo htmlspecialchars($courseData['id_courses']); ?>">
                
                <div class="form-group">
                    <label for="title">Titre du cours</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($courseData['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($courseData['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="content_type">Type de contenu</label>
                    <select id="content_type" name="content_type" required>
                        <option value="video" <?php echo $courseData['content_type'] === 'video' ? 'selected' : ''; ?>>Vidéo</option>
                        <option value="document" <?php echo $courseData['content_type'] === 'document' ? 'selected' : ''; ?>>Document</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="content_url">URL du contenu</label>
                    <input type="url" id="content_url" name="content_url" value="<?php echo htmlspecialchars($courseData['content_url']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Catégorie</label>
                    <select id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id_categories']; ?>" 
                                    <?php echo $courseData['category_id'] == $category['id_categories'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tags">Tags</label>
                    <select id="tags" name="tags[]" multiple>
                        <?php 
                        $courseTags = explode(',', $courseData['tag_ids']);
                        foreach ($tags as $tag): 
                        ?>
                            <option value="<?php echo $tag['id_tags']; ?>"
                                    <?php echo in_array($tag['id_tags'], $courseTags) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($tag['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group hidden">
                    <label for="status">Statut</label>
                    <select id="status" name="status" required>
                        <option value="draft" <?php echo $courseData['status'] === 'draft' ? 'selected' : ''; ?>>Brouillon</option>
                        <option value="published" <?php echo $courseData['status'] === 'published' ? 'selected' : ''; ?>>Publié</option>
                        <option value="archived" <?php echo $courseData['status'] === 'archived' ? 'selected' : ''; ?>>Archivé</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Mettre à jour le cours</button>
                    <a href="Course_Management_teacher.php" class="btn" style="background: #6b7280;">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
