<?php
namespace App\Controllers;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\User;

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}




class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = htmlspecialchars(trim($_POST["username"]));
            $email = htmlspecialchars(trim($_POST["email"]));
            $password = trim($_POST["password"]);
            $role = "student"; // Default role

            // Validate inputs
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION["register_error"] = "All fields are required.";
                header("Location: /student_forum/app/views/pages/register.php");
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION["register_error"] = "Invalid email format.";
                header("Location: /student_forum/app/views/pages/register.php");
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION["register_error"] = "Password must be at least 6 characters.";
                header("Location: /student_forum/app/views/pages/register.php");
                exit;
            }

            // Check if the username or email already exists
            if ($this->userModel->findByUsernameOrEmail($username, $email)) {
                $_SESSION["register_error"] = "Username or email already exists.";
                header("Location: /student_forum/app/views/pages/register.php");
                exit;
            }

            // Securely hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user
            if ($this->userModel->createUser($username, $email, $hashed_password)) {
                $_SESSION["user_id"] = $this->userModel->findByEmail($email)['user_id'];
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;
                header("Location: /student_forum/public/index.php");
                exit;
            } else {
                $_SESSION["register_error"] = "Registration failed. Please try again.";
                header("Location: /student_forum/app/views/pages/register.php");
                exit;
            }
        }
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars(trim($_POST["email"]));
            $password = $_POST["password"];

            // Validate inputs
            if (empty($email) || empty($password)) {
                $_SESSION["login_error"] = "All fields are required.";
                header("Location: /student_forum/app/views/pages/login.php");
                exit;
            }
            // Verify password
            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];
                header("Location: /student_forum/public/index.php");
                exit;
            } else {
                $_SESSION["login_error"] = "Invalid email or password.";
                header("Location: /student_forum/app/views/pages/login.php");
                exit;
            }               
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /student_forum/public/index.php");
        exit;
    }
   


}

$authController = new AuthController();

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'register') {
        $authController->register();
    } elseif ($_GET['action'] == 'login') {
        $authController->login();
    } elseif ($_GET['action'] == 'logout') {
        $authController->logout();
    }
}   
?>
