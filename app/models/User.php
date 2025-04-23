<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class User {
    private $db;

    public function __construct() {
        // Đảm bảo database được kết nối
        require_once __DIR__ . '/../../config/database.php';
        
        // Sử dụng biến global $db từ file database.php
        global $db;
        if (!$db) {
            // Nếu chưa có kết nối, tạo một kết nối mới
            $database = new Database();
            $db = $database->connect();
        }
        
        $this->db = $db;
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findByUsernameOrEmail($username, $email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        return $stmt->fetch();
    }

    public function createUser($username, $email, $hashed_password, $role = 'student') {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$username, $email, $hashed_password, $role]);
    }


    // admin functions
    public function getAllUsers() {
        $stmt = $this->db->prepare("SELECT user_id, username, email, role, created_at FROM users ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function deleteUser($user_id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }
    public function updateUserRole($user_id, $role) {
        $stmt = $this->db->prepare("UPDATE users SET role = ? WHERE user_id = ?");
        return $stmt->execute([$role, $user_id]);
    }
    public function getUserById($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) return false;
        
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    public function countUsers() {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
