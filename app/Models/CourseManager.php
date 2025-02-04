<?php 
namespace Coursemanager;
use PDO;

abstract class Course {
    protected $title;
    protected $description;
    protected $content_type;
    protected $content_url;
    
    public function __construct($title, $description, $content_type, $content_url) {
        $this->title = $title;
        $this->description = $description;
        $this->content_type = $content_type;
        $this->content_url = $content_url;
    }

    abstract public function getContentDetails();
}

class VideoCourse extends Course {
    public function getContentDetails() {
        return "Video URL: " . $this->content_url;
    }
}

class DocumentCourse extends Course {
    public function getContentDetails() {
        return "Document URL: " . $this->content_url;
    }
}

class CourseManager {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getCourses($categoryId = null, $tagId = null) {
        $query = "SELECT DISTINCT c.*, 
                    u.username as teacher_name,
                    cat.name as category_name,
                    (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id_courses) as student_count
                 FROM courses c
                 JOIN users u ON c.teacher_id = u.id_user
                 JOIN categories cat ON c.category_id = cat.id_categories
                 LEFT JOIN course_tags ct ON c.id_courses = ct.course_id
                 WHERE 1=1";
        
        $params = [];
        
        if ($categoryId) {
            $query .= " AND c.category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }
        
        if ($tagId) {
            $query .= " AND EXISTS (
                SELECT 1 FROM course_tags ct2 
                WHERE ct2.course_id = c.id_courses 
                AND ct2.tag_id = :tag_id
            )";
            $params[':tag_id'] = $tagId;
        }
        
        $query .= " ORDER BY c.title";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseTags($courseId) {
        $query = "SELECT t.* FROM tags t
                 JOIN course_tags ct ON t.id_tags = ct.tag_id
                 WHERE ct.course_id = :course_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':course_id' => $courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCourse($courseId) {
        $query = "DELETE FROM courses WHERE id_courses = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $courseId]);
    }

    public function addCourse(array $courseData) {
        try {
            $this->conn->beginTransaction();
            
            // Validate category exists
            $categoryStmt = $this->conn->prepare("SELECT id_categories FROM categories WHERE id_categories = :category_id");
            $categoryStmt->execute([':category_id' => $courseData['category']]);
            if (!$categoryStmt->fetch()) {
                throw new \Exception("Invalid category selected");
            }
            
            // Instantiate the appropriate course object based on content type
            if ($courseData['content_type'] === 'video') {
                $course = new VideoCourse(
                  $courseData['title'], 
                  $courseData['description'], 
                  $courseData['content_type'], 
                  $courseData['content']
                );
            } else {
                $course = new DocumentCourse(
                  $courseData['title'], 
                  $courseData['description'], 
                  $courseData['content_type'], 
                  $courseData['content']
                );
            }
            
            // Use the course object to get content details
            $contentDetails = $course->getContentDetails();

            // Insert course into database with these details
            $courseQuery = "INSERT INTO courses (
                title, 
                description, 
                content_type, 
                content_url, 
                category_id, 
                teacher_id,
                status
            ) VALUES (
                :title,
                :description,
                :content_type,
                :content_url,
                :category_id,
                :teacher_id,
                'published'
            )";
            
            $stmt = $this->conn->prepare($courseQuery);
            $stmt->execute([
                ':title' => $courseData['title'],
                ':description' => $courseData['description'],
                ':content_type' => $courseData['content_type'],
                ':content_url' => $contentDetails,
                ':category_id' => $courseData['category'],
                ':teacher_id' => $courseData['teacher_id']
            ]);
            
            $courseId = $this->conn->lastInsertId();
            
            // Handle tags if provided
            if (!empty($courseData['tags'])) {
                $tags = array_map('trim', explode(',', $courseData['tags']));
                
                foreach ($tags as $tag) {
                    if (empty($tag)) continue;
                    
                    // First try to find if tag exists
                    $tagQuery = "SELECT id_tags FROM tags WHERE name = :name";
                    $stmt = $this->conn->prepare($tagQuery);
                    $stmt->execute([':name' => $tag]);
                    $existingTag = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // If tag doesn't exist, create it
                    if (!$existingTag) {
                        $createTagQuery = "INSERT INTO tags (name) VALUES (:name)";
                        $stmt = $this->conn->prepare($createTagQuery);
                        $stmt->execute([':name' => $tag]);
                        $tagId = $this->conn->lastInsertId();
                    } else {
                        $tagId = $existingTag['id_tags'];
                    }
                    
                    // Check if this course-tag relationship already exists
                    $existingRelationQuery = "SELECT 1 FROM course_tags WHERE course_id = :course_id AND tag_id = :tag_id";
                    $stmt = $this->conn->prepare($existingRelationQuery);
                    $stmt->execute([
                        ':course_id' => $courseId,
                        ':tag_id' => $tagId
                    ]);
                    
                    if (!$stmt->fetch()) {
                        $courseTagQuery = "INSERT INTO course_tags (course_id, tag_id) VALUES (:course_id, :tag_id)";
                        $stmt = $this->conn->prepare($courseTagQuery);
                        $stmt->execute([
                            ':course_id' => $courseId,
                            ':tag_id' => $tagId
                        ]);
                    }
                }
            }
            
            $this->conn->commit();
            return $courseId;
            
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    public function getCourseDetails($id) {
        $query = "SELECT c.*, u.username as teacher_name, cat.name as category_name 
                  FROM courses c
                  LEFT JOIN users u ON c.teacher_id = u.id_user
                  LEFT JOIN categories cat ON c.category_id = cat.id_categories
                  WHERE c.id_courses = ? AND c.status = 'published'";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getCoursesWithPagination($categoryId = null, $searchQuery = '', $page = 1, $itemsPerPage = 3) {
        // Calculate the offset
        $offset = ($page - 1) * $itemsPerPage;
        
        // Base query
        $query = "SELECT c.*, cat.name as category_name, u.username as teacher_name,
                 (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.id_courses) as enrollment_count
                 FROM courses c
                 LEFT JOIN categories cat ON c.category_id = cat.id_categories
                 LEFT JOIN users u ON c.teacher_id = u.id_user
                 WHERE 1=1";
        
        // Add category filter
        if ($categoryId) {
            $query .= " AND c.category_id = :categoryId";
        }
        
        // Add search filter
        if ($searchQuery) {
            $query .= " AND (c.title LIKE :searchQuery OR c.description LIKE :searchQuery)";
        }
        
        // Add pagination
        $query .= " LIMIT :offset, :itemsPerPage";
        
        // Prepare and execute the query
        $stmt = $this->conn->prepare($query);
        
        if ($categoryId) {
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        }
        
        if ($searchQuery) {
            $searchParam = "%$searchQuery%";
            $stmt->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
        }
        
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
        
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get total count for pagination
        $countQuery = "SELECT COUNT(*) FROM courses c WHERE 1=1";
        if ($categoryId) {
            $countQuery .= " AND c.category_id = :categoryId";
        }
        if ($searchQuery) {
            $countQuery .= " AND (c.title LIKE :searchQuery OR c.description LIKE :searchQuery)";
        }
        
        $stmtCount = $this->conn->prepare($countQuery);
        
        if ($categoryId) {
            $stmtCount->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        }
        if ($searchQuery) {
            $stmtCount->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
        }
        
        $stmtCount->execute();
        $totalItems = $stmtCount->fetchColumn();
        $totalPages = ceil($totalItems / $itemsPerPage);
        
        return [
            'courses' => $courses,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'itemsPerPage' => $itemsPerPage,
            'totalItems' => $totalItems
        ];
    }


    
}
?>
