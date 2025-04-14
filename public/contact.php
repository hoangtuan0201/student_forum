<?php
session_start();
require_once '../app/models/Email.php';

// Clear previous messages
if(isset($_SESSION['email_error'])) {
    unset($_SESSION['email_error']);
}
if(isset($_SESSION['email_success'])) {
    unset($_SESSION['email_success']);
}
if(!isset($_SESSION['user_id'])){
    $_SESSION["login_error"] = "You have to login to send email.";       
    header('Location: /student_forum/app/views/auth/login.php');
    exit;
    
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    $_SESSION['email_error'] = [];
    
    if (empty($name)) {
        $_SESSION['email_error'][] = "Name is required";
    }
    
    if (empty($email)) {
        $_SESSION['email_error'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_error'] = "Please enter a valid email address";
    }
    
    if (empty($subject)) {
        $_SESSION['email_error'] = "Subject is required";
    }
    
    if (empty($message)) {
        $_SESSION['email_error'] = "Message is required";
    }
    
    // If no errors, send email
    if (empty($_SESSION['email_error'])) {
        $emailer = new Email();
        
        $htmlMessage = "
            <h2>Student Question</h2>
            <p><strong>Student Name:</strong> " . htmlspecialchars($name) . "</p>
            <p><strong>Student Email:</strong> " . htmlspecialchars($email) . "</p>
            <p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
            <p><strong>Student Question:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
        ";
        
        $sendTo = 'tuanthhgcs230462@fpt.edu.vn'; // Admin email
        
        if ($emailer->sendContactEmail($sendTo, "Student Question: " . ($subject), $htmlMessage, $email, $name)) {
            $_SESSION['email_success'] = "Your question has been sent! We'll respond to you as soon as possible.";
            // Reset form data after successful submission
            $name = $email = $subject = $message = '';
        } else {
            $_SESSION['email_error'] = ["Failed to send email. Please try again later."];
        }
    }
}
?>
    <style>
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        textarea.form-control {
            min-height: 150px;
        }
        
        .btn-submit {
            padding: 12px 24px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn-submit:hover {
            background: #0069d9;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

    <?php include '../app/views/includes/header.php'; ?>
    
    <div class="container">
    <h1 class="h2 mb-4 mt-3">Contact Us</h1>
        
        <?php if (isset($_SESSION['email_success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['email_success']; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['email_error'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($_SESSION['email_error'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="contact-form">
            <form method="POST" action="contact.php">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="subject">Question Topic</label>
                    <input type="text" id="subject" name="subject" class="form-control" value="<?php echo htmlspecialchars($subject ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="message">Your Question</label>
                    <textarea id="message" name="message" class="form-control" placeholder="Type your question here..."><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-submit">Send Question</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php include '../app/views/includes/footer.php'; ?>
