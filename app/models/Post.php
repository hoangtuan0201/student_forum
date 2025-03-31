<?php
require_once __DIR__ . '/../../config/database.php';

class Post {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->connect();
    }
<<<<<<< HEAD
=======
    // Fetch all posts
>>>>>>> e4d2bd746c442ec95dbf71609c8a27b97cdcac32

    public function getAllPosts() {
        $stmt = $this->pdo->query("SELECT posts.*, users.username, modules.module_name 
                                    FROM posts 
                                    JOIN users ON posts.user_id = users.user_id 
                                    JOIN modules ON posts.module_id = modules.module_id 
                                    ORDER BY posts.created_at DESC");
<<<<<<< HEAD
        return $stmt->fetchAll();
    }
=======
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get a single post by ID
>>>>>>> e4d2bd746c442ec95dbf71609c8a27b97cdcac32

    public function getPostById($post_id) {
        $stmt = $this->pdo->prepare("SELECT posts.*, users.username, modules.module_name 
                                     FROM posts 
                                     JOIN users ON posts.user_id = users.user_id 
                                     JOIN modules ON posts.module_id = modules.module_id 
                                     WHERE posts.post_id = ?");
        $stmt->execute([$post_id]);
<<<<<<< HEAD
        return $stmt->fetch();
    }
    public function getUserPost($user_id) {
            $stmt = $this->pdo->prepare("SELECT posts.*, users.username, modules.module_name
            FROM posts
            JOIN users ON posts.user_id = users.user_id
            JOIN modules ON posts.module_id = modules.module_id
            WHERE posts.user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
        
=======
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Create a new post
>>>>>>> e4d2bd746c442ec95dbf71609c8a27b97cdcac32

    public function createPost($user_id, $module_id, $title, $content, $image = null) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (user_id, module_id, title, content, image, created_at) 
                                     VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $module_id, $title, $content, $image]);
    }
    

<<<<<<< HEAD
=======
    // Update a post
>>>>>>> e4d2bd746c442ec95dbf71609c8a27b97cdcac32
    public function updatePost($post_id, $title, $content, $module_id, $image_path, $user_id) {
        $stmt = $this->pdo->prepare("UPDATE posts SET title = ?, content = ?, module_id = ?, image = ? WHERE post_id = ? AND user_id = ?");
        return $stmt->execute([$title, $content, $module_id, $image_path, $post_id, $user_id]);
    }


<<<<<<< HEAD
    public function deletePost($post_id, $user_id) {
=======
     // Delete a post
     public function deletePost($post_id, $user_id) {
>>>>>>> e4d2bd746c442ec95dbf71609c8a27b97cdcac32
        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE post_id = ? AND user_id = ?");
        return $stmt->execute([$post_id, $user_id]);
    }
    
<<<<<<< HEAD

    
=======
>>>>>>> e4d2bd746c442ec95dbf71609c8a27b97cdcac32
    public function countAllPosts() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM posts");
        return $stmt->fetchColumn();
    }
}
?>
