<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

// Load database connection
require_once __DIR__ . '/../config/database.php';

// Define common constants
define('BASE_URL', $_ENV['BASE_URL'] ?? '/student_forum');
define('ROOT_PATH', dirname(__DIR__));
define('UPLOAD_PATH', ROOT_PATH . '/public/uploads/');

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', $_ENV['DEBUG'] ?? false);

// Set timezone
date_default_timezone_set('UTC');

// Add any other common setup functions here
function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit;
}

function flash($type, $message) {
    $_SESSION[$type] = $message;
} 