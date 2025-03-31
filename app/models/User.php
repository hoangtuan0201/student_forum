<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->connect();
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
<<<<<<< HEAD
        return $stmt->fetch();
=======
        return $stmt->fetch(PDO::FETCH_ASSOC);
>>>>>>> e4d2bd746c442ec95dbf71609c8a27b97cdcac32
    }

    public function findByUsernameOrEmail($username, $email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
<<<<<<< HEAD
        return $stmt->fetch();
=======
        return $stmt->fetch(PDO::FETCH_ASSOC);
>>>>>>> e4d2bd746c442ec95dbf71609c8a27b97cdcac32
    }

    public function createUser($username, $email, $password, $role = 'student') {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$username, $email, $hashed_password, $role]);
    }
}
