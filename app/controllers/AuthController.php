<?php
session_start();
include '../../config/database.php';

$database = new Database();
$pdo = $database->connect(); // Now $pdo is properly initialized

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
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
                header("Location: ../../app/views/register.php");
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION["register_error"] = "Invalid email format.";
                header("Location: ../../app/views/register.php");
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION["register_error"] = "Password must be at least 6 characters.";
                header("Location: ../../app/views/register.php");
                exit;
            }

            // Check if the username or email already exists
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $_SESSION["register_error"] = "Username or email already exists.";
                header("Location: ../../app/views/register.php");
                exit;
            }

            // Securely hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user
            $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            if ($stmt->execute([$username, $email, $hashed_password, $role])) {
                $_SESSION["user_id"] = $this->pdo->lastInsertId();
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;
                header("Location: ../../public/index.php");
                exit;
            } else {
                $_SESSION["register_error"] = "Registration failed. Please try again.";
                header("Location: ../../app/views/register.php");
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
                header("Location: ../../app/views/login.php");
                exit;
            }

            // Check if the user exists
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // Verify password
            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];
                header("Location: ../../public/index.php");
                exit;
            } else {
                $_SESSION["login_error"] = "Invalid email or password.";
                header("Location: ../../app/views/login.php");
                exit;
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../../public/index.php");
        exit;
    }
}

// Handle actions from URLs
$authController = new AuthController($pdo);

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
