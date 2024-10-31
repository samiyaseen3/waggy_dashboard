<?php

// File: model/Category.php
require_once 'Database.php';

class Category {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCategories() {
        $query = "SELECT * FROM categories WHERE category_state = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCategory($name, $description, $picture) {
        $sql = "INSERT INTO categories (category_name, category_description, category_picture) VALUES (:name, :description, :picture)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':picture', $picture);
        return $stmt->execute();
    }

    // Optional: Fetch a category by ID for editing
    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE category_id = :id AND category_state = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Optional: Edit a category
    public function updateCategory($id, $name, $description, $picture) {
        $sql = "UPDATE categories SET category_name = :name, category_description = :description, category_picture = :picture WHERE category_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':picture', $picture);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function softDeleteCategory($categoryId)
{
    $sql = "UPDATE categories SET category_state = 0 WHERE category_id = :category_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    return $stmt->execute();
}
    
}

?>