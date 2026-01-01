<?php
class QuickLink {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM quick_links ORDER BY sort_order ASC, id DESC");
    }

    public function create($data) {
        return $this->db->insert(
            "INSERT INTO quick_links (title, url, sort_order) VALUES (:title, :url, :sort_order)",
            [
                ':title' => $data['title'],
                ':url' => $data['url'],
                ':sort_order' => $data['sort_order'] ?? 0
            ]
        );
    }

    public function delete($id) {
        return $this->db->query("DELETE FROM quick_links WHERE id = :id", [':id' => $id]);
    }

    public function update($id, $data) {
        return $this->db->query(
            "UPDATE quick_links SET title = :title, url = :url, sort_order = :sort_order WHERE id = :id",
            [
                ':id' => $id,
                ':title' => $data['title'],
                ':url' => $data['url'],
                ':sort_order' => $data['sort_order'] ?? 0
            ]
        );
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM quick_links WHERE id = :id", [':id' => $id]);
    }
}