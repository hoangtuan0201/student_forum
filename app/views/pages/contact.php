<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load environment variables first
try {
    require_once __DIR__ . '/../../../vendor/autoload.php';
    
    if (file_exists(__DIR__ . '/../../../.env')) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../..');
        $dotenv->load();
    }
} catch (Exception $e) {
    error_log("Error loading .env file in contact page: " . $e->getMessage());
    // Tiếp tục mà không tải .env
}

// Then load the Email model
use App\Models\Email;

if(!isset($_SESSION['user_id'])){
    $_SESSION["login_error"] = "You have to login to send email.";
    header('Location: /student_forum/app/views/pages/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Kiểm tra xem đã cấu hình email chưa
        if (empty($_ENV['EMAIL']) || empty($_ENV['EMAIL_APP_PASSWORD'])) {
            throw new Exception("Email configuration is missing. Please configure EMAIL and EMAIL_APP_PASSWORD in .env file.");
        }
        
        $emailer = new Email();

        $htmlMessage = "
            <h2>Student Question</h2>
            <p><strong>Student Name:</strong> " . htmlspecialchars($_POST['name']) . "</p>
            <p><strong>Student Email:</strong> " . htmlspecialchars($_POST['email']) . "</p>
            <p><strong>Subject:</strong> " . htmlspecialchars($_POST['subject']) . "</p>
            <p><strong>Student Question:</strong></p>
            <p>" . nl2br(htmlspecialchars($_POST['message'])) . "</p>
        ";

        $sendTo = $_ENV['EMAIL'];

        if ($emailer->sendContactEmail($sendTo, "Student Question: " . $_POST['subject'], $htmlMessage, $_POST['email'], $_POST['name'])) {
            $_SESSION['email_success'] = "Your question has been sent! We'll respond to you as soon as possible.";
        } else {
            $error = $emailer->getLastError();
            $_SESSION['email_send_error'] = "Failed to send email: " . ($error ? $error : "Unknown error occurred");
            error_log("Contact form email error: " . ($error ? $error : "Unknown error"));
        }
        header("Location: /student_forum/app/views/pages/contact.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['email_send_error'] = "Configuration error preventing email sending: " . $e->getMessage();
        error_log("Failed to initialize Emailer: " . $e->getMessage());
        header("Location: /student_forum/app/views/pages/contact.php");
        exit;
    }
}

include '../components/header.php';
?>

<div class="container">
    <div class="main-body p-0">
        <div class="inner-wrapper">
            <div class="inner-main">
                <div class="inner-main-body">
                    <!-- Include alerts here, right after opening the main body -->
                    <?php include '../components/alerts.php'; ?> 

                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2 mb-4">Contact Us</h1>
                            
                            <?php if (empty($_ENV['EMAIL']) || empty($_ENV['EMAIL_APP_PASSWORD'])): ?>
                                <div class="alert alert-warning">
                                    <strong>Notice:</strong> Email functionality is not available. Please configure the email settings.
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="name">Your Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Your Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label for="subject">Question Topic</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>

                                <div class="form-group">
                                    <label for="message">Your Question</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" <?php echo (empty($_ENV['EMAIL']) || empty($_ENV['EMAIL_APP_PASSWORD'])) ? 'disabled' : ''; ?>>Send Question</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?> 