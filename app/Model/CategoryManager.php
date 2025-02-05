<?php
namespace Categorymanager;
use PDO;

class Category {
    public $id;
    public $name;
    public $description;

    public function __construct($id, $name, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

}

class CategoryManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category($row['id_categories'], $row['name'], $row['description']);
        }

        return $categories;
    }

    public function addCategory($name, $description = '') {
        $query = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':name' => $name,
            ':description' => $description
        ]);
    }

    public function updateCategory($id, $name, $description = '') {
        $query = "UPDATE categories SET name = :name, description = :description WHERE id_categories = :id";
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description
        ]);
    }

    public function deleteCategory($id) {
        $query = "DELETE FROM categories WHERE id_categories = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([':id' => $id]);
    }

    public function findCategoryByName($name) {
        $query = "SELECT * FROM categories WHERE name LIKE :name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':name' => '%' . $name . '%']);

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category($row['id_categories'], $row['name'], $row['description']);
        }

        return $categories;
    }
}
?>
