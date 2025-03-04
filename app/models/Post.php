<?php
require_once __DIR__ . '/../../config/database.php';

class Post {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->connect();
    }

    public function getAllPosts() {
        $stmt = $this->pdo->query("SELECT posts.*, users.username, modules.module_name 
                                    FROM posts 
                                    JOIN users ON posts.user_id = users.user_id 
                                    JOIN modules ON posts.module_id = modules.module_id 
                                    ORDER BY posts.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById($post_id) {
        $stmt = $this->pdo->prepare("SELECT posts.*, users.username, modules.module_name 
                                     FROM posts 
                                     JOIN users ON posts.user_id = users.user_id 
                                     JOIN modules ON posts.module_id = modules.module_id 
                                     WHERE posts.post_id = ?");
        $stmt->execute([$post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPost($user_id, $module_id, $title, $content, $image = null) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (user_id, module_id, title, content, image, created_at) 
                                     VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $module_id, $title, $content, $image]);
    }
}
?>
