<?php

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Module.php';
class AdminController {
    private $authController;
    private $userModel;
    private $postModel;
    private $moduleModel;
    
    public function __construct() {
        $this->authController = new AuthController();
        $this->userModel = new User();
        $this->postModel = new Post();
        $this->moduleModel = new Module();
        
        // Check if user is admin
        $this->authController->requireAdmin();
    }
    
    // User management
    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }
    
    public function deleteUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
            $user_id = $_POST["user_id"];
            
            // Don't allow deleting yourself
            if ($user_id == $_SESSION["user_id"]) {
                $_SESSION["error"] = "You cannot delete your own account.";
                header("Location: users.php");
                exit;
            }
            
            if ($this->userModel->deleteUser($user_id)) {
                $_SESSION["success"] = "User deleted successfully.";
            } else {
                $_SESSION["error"] = "Failed to delete user.";
            }
            
            header("Location: users.php");
            exit;
        }
    }

    public function updateUserRole() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"]) && isset($_POST["role"])) {
            $user_id = $_POST["user_id"];
            $role = $_POST["role"];
            
            if ($this->userModel->updateUserRole($user_id, $role)) {
                $_SESSION["success"] = "User role updated successfully.";
            } else {
                $_SESSION["error"] = "Failed to update user role.";
            }
            
            header("Location: users.php");
            exit;
        }
    }

    // Post management
    public function getAllPosts() {
        return $this->postModel->getAllPosts();
    }
    
    public function deletePost() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_id"])) {
            $post_id = $_POST["post_id"];
            
            if ($this->postModel->deletePostFromAdmin($post_id)) {
                $_SESSION["success"] = "Post deleted successfully.";
            } else {
                $_SESSION["error"] = "Failed to delete post.";
            }
            
            header("Location: posts.php");
            exit;
        }
    }
    // Module management
    public function getAllModules() {
        return $this->moduleModel->getAllModules();
    }
    
    public function createModule() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $module_name = htmlspecialchars(trim($_POST["module_name"]));
            
            if (empty($module_name)) {
                $_SESSION["error"] = "Module name is required.";
                header("Location: modules.php");
                exit;
            }
            
            if ($this->moduleModel->createModule($module_name)) {
                $_SESSION["success"] = "Module created successfully.";
            } else {
                $_SESSION["error"] = "Failed to create module.";
            }
            
            header("Location: modules.php");
            exit;
        }
    }
    public function updateModule() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["module_id"])) {
            $module_id = $_POST["module_id"];
            $module_name = htmlspecialchars(trim($_POST["module_name"]));
            
            if (empty($module_name) || empty($module_code)) {
                $_SESSION["error"] = "Module name is required.";
                header("Location: modules.php");
                exit;
            }
            
            if ($this->moduleModel->updateModule($module_id, $module_name)) {
                $_SESSION["success"] = "Module updated successfully.";
            } else {
                $_SESSION["error"] = "Failed to update module.";
            }
            
            header("Location: modules.php");
            exit;
        }
    }

    public function deleteModule() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["module_id"])) {
            $module_id = $_POST["module_id"];
            
            if ($this->moduleModel->deleteModule($module_id)) {
                $_SESSION["success"] = "Module deleted successfully.";
            } else {
                $_SESSION["error"] = "Failed to delete module.";
            }
            
            header("Location: modules.php");
            exit;
        }
    }
    // Dashboard statistics
    public function getDashboardStats() {
        $stats = [
            'total_users' => $this->userModel->countUsers(),
            'total_posts' => $this->postModel->countAllPosts(),
            'total_modules' => $this->moduleModel->countModules()
        ];
        
        return $stats;
    }


}


?>