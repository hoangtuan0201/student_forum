
<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

include_once __DIR__ . '/../../config/database.php'; // Use __DIR__ to ensure the correct path
include_once __DIR__ . '/../models/Post.php'; // Use __DIR__ to ensure the correct path

$database = new Database(); // No namespace needed
$pdo = $database->connect(); // Connect to the database
$postModel = new Post($pdo); // Create an instance of the Post model

class PostController {
    private $postModel;

    public function __construct($postModel) {
        $this->postModel = $postModel;
    }

    public function create_post() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_SESSION["user_id"])) {
                $_SESSION["post_error"] = "You have to login first to post Question.";
                header("Location: ../../app/views/auth/login.php");
                exit;
            }

            $user_id = $_SESSION["user_id"];
            $title = htmlspecialchars(trim($_POST["title"]));
            $content = htmlspecialchars(trim($_POST["content"]));
            $module_id = $_POST["module_id"];
            $image_path = null;

            // Debugging: Check if form data is received
            error_log("Form Data: User ID: $user_id, Title: $title, Content: $content, Module ID: $module_id");

            // Handle Image Upload
            if (!empty($_FILES["image"]["name"])) {
                $target_dir = "../../public/uploads/";
                $image_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $image_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = "public/uploads/" . $image_name;
                }
            }

            // Create the post using the model
            if ($this->postModel->createPost($user_id, $module_id, $title, $content, $image_path)) {
                header("Location: ../../public/index.php");
                exit;
            } else {
                $_SESSION["post_error"] = "Error creating post.";
                header("Location: ../../public/new_post.php");
                exit;
            }
        }
    }

    public function displayPosts() {
        return $this->postModel->getAllPosts();
    }
}

// Instantiate the controller
$postController = new PostController($postModel);

if (isset($_GET["action"]) && $_GET["action"] == "create_post") {
    $postController->create_post();
}
?>

