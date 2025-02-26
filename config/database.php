<?php

class Database {
    private $host = "localhost";  // Change if needed
    private $db_name = "student_forum";  // Your database name
    private $username = "root";  // Change if needed
    private $password = "";  // Change if you have a password
    public $conn;

    public function connect() {
        $this->conn = null;

        try {
            // Check if PDO is available
            if (!class_exists('PDO')) {
                throw new Exception("PDO extension is not installed.");
            }

            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            //$dsn (Data Source Name): Defines the database type (mysql), host, database name, and charset (utf8mb4 for better Unicode support).
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Enables error handling, so errors are reported as exceptions.
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Fetch results as an associative array (e.g., ['id' => 1, 'name' => 'John'] instead of indexed arrays).
                PDO::ATTR_EMULATE_PREPARES => false, //PDO::ATTR_EMULATE_PREPARES => false: Prevents SQL injection by using real prepared statements.
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            return $this->conn;
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage(), 0);
            throw new Exception("Connection failed. Please try again later.");
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage(), 0);
            throw new Exception("An error occurred. Please try again later.");
        }
    }
}
?>
