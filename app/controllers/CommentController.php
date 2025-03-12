<?php
require_once __DIR__ . '/../models/Comment.php';

class CommentController {
    private $commentModel;
    
    public function __construct() {
        $this->commentModel = new Comment();
    }
    
    public function getCommentsByPostId($post_id) {
        return $this->commentModel->getCommentsByPostId($post_id);
    }
    
    public function createComment($user_id, $post_id, $content) {
        return $this->commentModel->createComment($user_id, $post_id, $content);
    }
    
    public function deleteComment($comment_id, $user_id) {
        return $this->commentModel->deleteComment($comment_id, $user_id);
    }
    
    public function countCommentsByPostId($post_id) {
        return $this->commentModel->countCommentsByPostId($post_id);
    }
    
    public function handleCommentAction() {
        session_start();
        
        // Kiểm tra người dùng đã đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: /student_forum/login.php');
            exit();
        }
        
        $user_id = $_SESSION['user_id'];
        
        // Xử lý các action
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['post_id'])) {
            $action = $_POST['action'];
            $post_id = $_POST['post_id'];
            
            switch ($action) {
                case 'create':
                    if (isset($_POST['content'])) {
                        $content = trim($_POST['content']);
                        
                        // Validate
                        if (empty($content)) {
                            $_SESSION['error'] = "Comment cannot be empty.";
                        } else {
                            // Lưu comment
                            $result = $this->createComment($user_id, $post_id, $content);
                            
                            if ($result) {
                                $_SESSION['success'] = "Comment added successfully.";
                            } else {
                                $_SESSION['error'] = "Failed to add comment.";
                            }
                        }
                    }
                    break;
                    
                case 'delete':
                    if (isset($_POST['comment_id'])) {
                        $comment_id = $_POST['comment_id'];
                        
                        // Xóa comment
                        $result = $this->deleteComment($comment_id, $user_id);
                        
                        if ($result) {
                            $_SESSION['success'] = "Comment deleted successfully.";
                        } else {
                            $_SESSION['error'] = "Failed to delete comment.";
                        }
                    }
                    break;
            }
            
            // Redirect về trang chi tiết bài viết
            header("Location: /student_forum/app/views/post/post_detail.php?id=$post_id");
            exit();
        }
        
        // Redirect nếu không có action hợp lệ
        header('Location: /student_forum/');
        exit();
    }
}