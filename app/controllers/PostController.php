<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/Post.php';

class PostController {
    private $postModel;

    public function __construct() {
        $this->postModel = new Post();
    }

    public function create_post() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_SESSION["user_id"])) {
                $_SESSION["post_error"] = "You have to login first to post a question.";
                header("Location: ../../app/views/auth/login.php");
                exit;
            }

            $user_id = $_SESSION["user_id"];
            $title = htmlspecialchars(trim($_POST["title"]));
            $content = htmlspecialchars(trim($_POST["content"]));
            $module_id = $_POST["module_id"];
            $image_path = null;

            // Validate inputs
            if (empty($title) || empty($content) || empty($module_id)) {
                $_SESSION["post_error"] = "All fields are required.";
                header("Location: ../../app/views/post/create.php");
                exit;
            }

            // Handle Image Upload
            if (!empty($_FILES["image"]["name"])) {
                $target_dir = "../../public/uploads/";
                $image_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $image_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = "public/uploads/" . $image_name;
                }
            }

            // Gọi model để tạo bài post
            if ($this->postModel->createPost($user_id, $module_id, $title, $content, $image_path)) {
                header("Location: ../../public/index.php");
                exit;
            } else {
                $_SESSION["post_error"] = "Error creating post.";
                header("Location: ../../app/views/post/create.php");
                exit;
            }
        }
    }
    public function deletePost() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_id"])) {
            $post_id = $_POST["post_id"];
            $user_id = $_SESSION["user_id"];
    
            if ($this->postModel->deletePost($post_id, $user_id)) {
                header("Location: /student_forum/public/my_question.php");
                exit;
            } else {
                echo "Error deleting post.";
            }
        }
    }
    

    public function getAllPosts() {
        return $this->postModel->getAllPosts();
    }

    public function getPostById($post_id) {
        return $this->postModel->getPostById($post_id);
    }

    public function getUserPost() {
        return $this->postModel->getUserPost($_SESSION["user_id"]);
        
    }
    

    public function countAllPosts() {
        return $this->postModel->countAllPosts();
    }


}

$postController = new PostController();

if (isset($_GET["action"])) {
    if ($_GET["action"] == "create_post") {
        $postController->create_post();
    }else if ($_GET["action"] == "delete_post") {
        $postController->deletePost();
    }
}
?>
