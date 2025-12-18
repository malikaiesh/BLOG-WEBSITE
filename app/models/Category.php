<?php

class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM categories WHERE id = :id", [':id' => $id]);
    }

    public function getBySlug($slug) {
        return $this->db->fetch("SELECT * FROM categories WHERE slug = :slug", [':slug' => $slug]);
    }

    public function create($data) {
        $sql = "INSERT INTO categories (name, slug, description) VALUES (:name, :slug, :description) RETURNING id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':slug' => $data['slug'] ?? generateSlug($data['name']),
            ':description' => $data['description'] ?? ''
        ]);
        return $stmt->fetch()['id'];
    }

    public function update($id, $data) {
        $sql = "UPDATE categories SET name = :name, slug = :slug, description = :description WHERE id = :id";
        return $this->db->query($sql, [
            ':id' => $id,
            ':name' => $data['name'],
            ':slug' => $data['slug'] ?? generateSlug($data['name']),
            ':description' => $data['description'] ?? ''
        ]);
    }

    public function delete($id) {
        return $this->db->query("DELETE FROM categories WHERE id = :id", [':id' => $id]);
    }

    public function getWithCount() {
        $sql = "SELECT c.*, COUNT(b.id) as post_count 
                FROM categories c 
                LEFT JOIN blogs b ON c.id = b.category_id AND b.status = 'published'
                GROUP BY c.id 
                ORDER BY c.name ASC";
        return $this->db->fetchAll($sql);
    }
}
