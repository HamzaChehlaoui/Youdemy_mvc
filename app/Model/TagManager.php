<?php 
        namespace Tagmanager;
        use PDO;

class TagManager {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllTags() {
        $query = "SELECT * FROM tags ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTag($name) {
        $query = "INSERT INTO tags (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':name' => $name]);
    }

    public function deleteTag($id) {
        $query = "DELETE FROM tags WHERE id_tags = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
?>