<?php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM users WHERE id = :id", [':id' => $id]);
    }

    public function getByEmail($email) {
        return $this->db->fetch("SELECT * FROM users WHERE email = :email", [':email' => $email]);
    }

    public function create($data) {
        $sql = "INSERT INTO users (name, email, password, role, created_at) 
                VALUES (:name, :email, :password, :role, NOW()) RETURNING id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':role' => $data['role'] ?? 'author'
        ]);
        return $stmt->fetch()['id'];
    }

    public function authenticate($email, $password) {
        $user = $this->getByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function updatePassword($id, $password) {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        return $this->db->query($sql, [
            ':id' => $id,
            ':password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET name = :name, email = :email, bio = :bio WHERE id = :id";
        return $this->db->query($sql, [
            ':id' => $id,
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':bio' => $data['bio'] ?? ''
        ]);
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC");
    }
}
