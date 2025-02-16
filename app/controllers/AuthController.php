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
            $password = password_hash(trim($_POST["password"]), PASSWORD_BCRYPT);
            $role = "student"; // Default role

            if (empty($username) || empty($email) || empty($password)) {
                die("All fields are required.");
            }

            // Check if the user exists
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                die("Username or email already exists.");
            }

            // Insert user
            $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            if ($stmt->execute([$username, $email, $password, $role])) {
                $_SESSION["user_id"] = $this->pdo->lastInsertId();
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;
                header("Location: ../../public/index.php");
                exit;
            } else {
                die("Error registering user.");
            }
        }
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars(trim($_POST["email"]));
            $password = $_POST["password"];

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];
                header("Location: ../../public/index.php");
                exit;
            } else {
                die("Invalid email or password.");
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../public/index.php");
        exit;
    }
}

$authController = new AuthController($pdo);

// Handle actions
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'register') {
        $authController->register();
    } elseif ($_GET['action'] == 'login') {
        $authController->login();
    } elseif ($_GET['action'] == 'logout') {
        $authController->logout();
    }
}
