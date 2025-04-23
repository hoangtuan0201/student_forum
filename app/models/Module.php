<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Module {
    private $pdo;
    
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
        
        $this->pdo = $db;
    }
    
    public function getAllModules() {
        $stmt = $this->pdo->prepare("SELECT * FROM modules ORDER BY module_name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getModuleById($module_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM modules WHERE module_id = ?");
        $stmt->execute([$module_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createModule($module_name) {
        $stmt = $this->pdo->prepare("INSERT INTO modules (module_name) VALUES (?)");
        return $stmt->execute([$module_name]);
    }
    
    public function updateModule($module_id, $module_name) {
        $stmt = $this->pdo->prepare("UPDATE modules SET module_name = ? WHERE module_id = ?");
        return $stmt->execute([$module_name, $module_id]);
    }
    
    public function deleteModule($module_id) {
        $stmt = $this->pdo->prepare("DELETE FROM modules WHERE module_id = ?");
        return $stmt->execute([$module_id]);
    }
    
    public function countModules() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM modules");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>
