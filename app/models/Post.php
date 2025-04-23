<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use Exception;

class Post {
    private $db;

    public function __construct() {
        // Đảm bảo database được kết nối
        require_once __DIR__ . '/../../config/database.php';
        
        // Sử dụng biến global $db từ file database.php
        global $db;
        if (!$db) {
            // Nếu chưa có kết nối, tạo một kết nối mới
            $database = new Database();
            $db = $database->connect();
        }
        
        $this->db = $db;
    }

    public function getAllPosts() {
        $stmt = $this->db->query("SELECT posts.*, users.username, modules.module_name 
                                    FROM posts 
                                    JOIN users ON posts.user_id = users.user_id 
                                    JOIN modules ON posts.module_id = modules.module_id 
                                    ORDER BY posts.created_at DESC");
        return $stmt->fetchAll();
    }

    public function getPostsByModule($module_id) {
        $stmt = $this->db->prepare("SELECT posts.*, users.username, modules.module_name 
                                    FROM posts 
                                    JOIN users ON posts.user_id = users.user_id 
                                    JOIN modules ON posts.module_id = modules.module_id 
                                    WHERE posts.module_id = ?
                                    ORDER BY posts.created_at DESC");
        $stmt->execute([$module_id]);
        return $stmt->fetchAll();
    }

    public function getPostById($post_id) {
        $stmt = $this->db->prepare("SELECT posts.*, users.username, modules.module_name 
                                     FROM posts 
                                     JOIN users ON posts.user_id = users.user_id 
                                     JOIN modules ON posts.module_id = modules.module_id 
                                     WHERE posts.post_id = ?");
        $stmt->execute([$post_id]);
        return $stmt->fetch();
    }
    public function getUserPost($user_id) {
            $stmt = $this->db->prepare("SELECT posts.*, users.username, modules.module_name
            FROM posts
            JOIN users ON posts.user_id = users.user_id
            JOIN modules ON posts.module_id = modules.module_id
            WHERE posts.user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
        
    // this is for user CRUD
    public function createPost($user_id, $module_id, $title, $content, $image = null) {
        $stmt = $this->db->prepare("INSERT INTO posts (user_id, module_id, title, content, image, created_at) 
                                     VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $module_id, $title, $content, $image]);
    }
    

    public function updatePost($post_id, $title, $content, $module_id, $image_path, $user_id) {
        $stmt = $this->db->prepare("UPDATE posts SET title = ?, content = ?, module_id = ?, image = ? WHERE post_id = ? AND user_id = ?");
        return $stmt->execute([$title, $content, $module_id, $image_path, $post_id, $user_id]);
    }

    
    public function deletePost($post_id, $user_id) {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE post_id = ? AND user_id = ?");
        return $stmt->execute([$post_id, $user_id]);
    }
    

    
    public function countAllPosts() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM posts");
        return $stmt->fetchColumn();
    }

    public function countAllPostsByUser($user_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM posts WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn();
    }
    
    public function countPostsByModule($module_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM posts WHERE module_id = ?");
        $stmt->execute([$module_id]);
        return $stmt->fetchColumn();
    }
    
    // THIS IS FOR admin Crud
    public function deletePostFromAdmin($post_id) {
        try {
            // Start transaction
            $this->db->beginTransaction();

            // First delete all comments associated with this post
            $stmt = $this->db->prepare("DELETE FROM comments WHERE post_id = ?");
            $stmt->execute([$post_id]);

            // Then delete the post
            $stmt = $this->db->prepare("DELETE FROM posts WHERE post_id = ?");
            $result = $stmt->execute([$post_id]);

            // If everything is successful, commit the transaction
            $this->db->commit();
            return $result;
        } catch (Exception $e) {
            // If there's an error, rollback the changes
            $this->db->rollBack();
            error_log("Error deleting post: " . $e->getMessage());
            return false;
        }
    }

    public function searchPosts($search) {
        $searchTerm = '%' . $search . '%';
        $query = "SELECT posts.*, users.username, modules.module_name 
                FROM posts 
                JOIN users ON posts.user_id = users.user_id 
                JOIN modules ON posts.module_id = modules.module_id 
                WHERE posts.title LIKE ? OR posts.content LIKE ?
                ORDER BY posts.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    // Get unassigned posts (posts that need to be assigned to users and modules)
    public function getUnassignedPosts() {
        $stmt = $this->db->prepare("SELECT * FROM posts 
                                    WHERE user_id IS NULL OR module_id IS NULL
                                    ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Assign a post to a user and module
    public function assignPost($post_id, $user_id, $module_id) {
        $stmt = $this->db->prepare("UPDATE posts SET user_id = ?, module_id = ? WHERE post_id = ?");
        return $stmt->execute([$user_id, $module_id, $post_id]);
    }
}
?>
