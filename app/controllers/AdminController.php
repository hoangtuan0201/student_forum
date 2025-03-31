<?php
session_start();
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Module.php';

class AdminController {
    private $userModel;
    private $postModel;
    private $moduleModel;
    
    public function __construct() {
        // Check if user is admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = "You don't have permission to access this page.";
            header("Location: /student_forum/public/index.php");
            exit;
        }
        
        $this->userModel = new User();
        $this->postModel = new Post();
        $this->moduleModel = new Module();
    }
    
    // User Management Methods
    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }
    
    public function deleteUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
            $user_id = $_POST["user_id"];
            
            // Don't allow deleting yourself
            if ($user_id == $_SESSION["user_id"]) {
                $_SESSION["error"] = "You cannot delete your own account.";
                header("Location: /student_forum/admin/users.php");
                exit;
            }
            
            if ($this->userModel->deleteUser($user_id)) {
                $_SESSION["success"] = "User deleted successfully.";
            } else {
                $_SESSION["error"] = "Failed to delete user.";
            }
            
            header("Location: /student_forum/admin/users.php");
            exit;
        }
    }
    
    public function updateUserRole() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"]) && isset($_POST["role"])) {
            $user_id = $_POST["user_id"];
            $role = $_POST["role"];
            
            // Don't allow changing your own role
            if ($user_id == $_SESSION["user_id"]) {
                $_SESSION["error"] = "You cannot change your own role.";
                header("Location: /student_forum/admin/users.php");
                exit;
            }
            
            // Validate role
            if (!in_array($role, ['student', 'admin'])) {
                $_SESSION["error"] = "Invalid role specified.";
                header("Location: /student_forum/admin/users.php");
                exit;
            }
            
            if ($this->userModel->updateUserRole($user_id, $role)) {
                $_SESSION["success"] = "User role updated successfully.";
            } else {
                $_SESSION["error"] = "Failed to update user role.";
            }
            
            header("Location: /student_forum/admin/users.php");
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

// Handle admin actions
$adminController = new AdminController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'deleteUser':
            $adminController->deleteUser();
            break;
        case 'updateUserRole':
            $adminController->updateUserRole();
            break;
        default:
            header("Location: /student_forum/admin/users.php");
            exit;
    }
}
?>