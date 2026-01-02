<?php

class Blog {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll($limit = 12, $offset = 0, $status = 'published') {
        $sql = "SELECT b.*, c.name as category_name, c.slug as category_slug,
                u.name as author_name
                FROM blogs b
                LEFT JOIN categories c ON b.category_id = c.id
                LEFT JOIN users u ON b.author_id = u.id
                WHERE b.status = :status
                ORDER BY b.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getBySlug($slug) {
        $sql = "SELECT b.*, c.name as category_name, c.slug as category_slug,
                u.name as author_name, u.avatar as author_avatar, u.bio as author_bio
                FROM blogs b
                LEFT JOIN categories c ON b.category_id = c.id
                LEFT JOIN users u ON b.author_id = u.id
                WHERE b.slug = :slug AND b.status = 'published'";
        
        return $this->db->fetch($sql, [':slug' => $slug]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM blogs WHERE id = :id";
        return $this->db->fetch($sql, [':id' => $id]);
    }

    public function create($data) {
        $sql = "INSERT INTO blogs (title, slug, excerpt, content, featured_image, 
                category_id, author_id, status, meta_title, meta_description, 
                created_at, updated_at)
                VALUES (:title, :slug, :excerpt, :content, :featured_image,
                :category_id, :author_id, :status, :meta_title, :meta_description,
                NOW(), NOW())
                RETURNING id";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':slug' => $data['slug'] ?? generateSlug($data['title']),
            ':excerpt' => $data['excerpt'] ?? '',
            ':content' => $data['content'],
            ':featured_image' => $data['featured_image'] ?? null,
            ':category_id' => $data['category_id'] ?? null,
            ':author_id' => $data['author_id'],
            ':status' => $data['status'] ?? 'draft',
            ':meta_title' => $data['meta_title'] ?? $data['title'],
            ':meta_description' => $data['meta_description'] ?? ''
        ]);
        
        return $stmt->fetch()['id'];
    }

    public function update($id, $data) {
        $sql = "UPDATE blogs SET 
                title = :title,
                slug = :slug,
                excerpt = :excerpt,
                content = :content,
                featured_image = COALESCE(:featured_image, featured_image),
                category_id = :category_id,
                status = :status,
                meta_title = :meta_title,
                meta_description = :meta_description,
                updated_at = NOW()
                WHERE id = :id";
        
        return $this->db->query($sql, [
            ':id' => $id,
            ':title' => $data['title'],
            ':slug' => $data['slug'] ?? generateSlug($data['title']),
            ':excerpt' => $data['excerpt'] ?? '',
            ':content' => $data['content'],
            ':featured_image' => $data['featured_image'] ?? null,
            ':category_id' => $data['category_id'] ?? null,
            ':status' => $data['status'] ?? 'published',
            ':meta_title' => $data['meta_title'] ?? $data['title'],
            ':meta_description' => $data['meta_description'] ?? ''
        ]);
    }

    public function delete($id) {
        return $this->db->query("DELETE FROM blogs WHERE id = :id", [':id' => $id]);
    }

    public function incrementViews($id) {
        return $this->db->query("UPDATE blogs SET views = views + 1 WHERE id = :id", [':id' => $id]);
    }

    public function getRelated($categoryId, $excludeId, $limit = 4) {
        $sql = "SELECT b.*, c.name as category_name 
                FROM blogs b
                LEFT JOIN categories c ON b.category_id = c.id
                WHERE b.category_id = :category_id 
                AND b.id != :exclude_id 
                AND b.status = 'published'
                ORDER BY b.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':exclude_id', $excludeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function search($query, $limit = 12) {
        $sql = "SELECT b.*, c.name as category_name 
                FROM blogs b
                LEFT JOIN categories c ON b.category_id = c.id
                WHERE b.status = 'published'
                AND (b.title ILIKE :query OR b.content ILIKE :query)
                ORDER BY b.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getByCategory($categorySlug, $limit = 12, $offset = 0) {
        $sql = "SELECT b.*, c.name as category_name 
                FROM blogs b
                LEFT JOIN categories c ON b.category_id = c.id
                WHERE c.slug = :slug AND b.status = 'published'
                ORDER BY b.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':slug', $categorySlug, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getTrending($limit = 5) {
        $sql = "SELECT b.*, c.name as category_name 
                FROM blogs b
                LEFT JOIN categories c ON b.category_id = c.id
                WHERE b.status = 'published'
                ORDER BY b.views DESC, b.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function count($status = null) {
        $sql = "SELECT COUNT(*) as count FROM blogs";
        if ($status) {
            $sql .= " WHERE status = :status";
            return $this->db->fetch($sql, [':status' => $status])['count'];
        }
        return $this->db->fetch($sql)['count'];
    }

    public function getAllAdmin($includeTrash = false) {
        $sql = "SELECT b.*, c.name as category_name, u.name as author_name
                FROM blogs b
                LEFT JOIN categories c ON b.category_id = c.id
                LEFT JOIN users u ON b.author_id = u.id";
        
        if ($includeTrash) {
            $sql .= " WHERE b.deleted_at IS NOT NULL";
        } else {
            $sql .= " WHERE b.deleted_at IS NULL";
        }
        
        $sql .= " ORDER BY b.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function softDelete($id) {
        return $this->db->query("UPDATE blogs SET deleted_at = NOW(), status = 'draft' WHERE id = :id", [':id' => $id]);
    }

    public function restore($id) {
        return $this->db->query("UPDATE blogs SET deleted_at = NULL WHERE id = :id", [':id' => $id]);
    }

    public function forceDelete($id) {
        return $this->db->query("DELETE FROM blogs WHERE id = :id", [':id' => $id]);
    }
}
