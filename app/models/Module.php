<?php
require_once __DIR__ . '/../../config/database.php';

class Module {
    private $pdo;
    
    public function __construct() {
        $database = new Database();
        $this->pdo = $database->connect();
    }
    
    public function getAllModules() {
        $stmt = $this->pdo->prepare("SELECT * FROM modules ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getModuleById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM modules WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createModule($name) {
        $stmt = $this->pdo->prepare("INSERT INTO modules (name) VALUES (?)");
        return $stmt->execute([$name]);
    }
    
    public function updateModule($id, $name) {
        $stmt = $this->pdo->prepare("UPDATE modules SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }
    
    public function deleteModule($id) {
        // First, check if there are any posts in this module
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM posts WHERE module_id = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            return false; // Cannot delete module with existing posts
        }
        
        $stmt = $this->pdo->prepare("DELETE FROM modules WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function countModules() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM modules");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>
