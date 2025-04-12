<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    private $mailer;
    private $config;

    public function __construct() {
        $this->config = require __DIR__ . '/../../config/email.php';
        $this->mailer = new PHPMailer(true);
        
        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['smtp']['host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config['smtp']['username'];
        $this->mailer->Password = $this->config['smtp']['password'];
        $this->mailer->SMTPSecure = $this->config['smtp']['encryption'];
        $this->mailer->Port = $this->config['smtp']['port'];
        
        // Sender info
        $this->mailer->setFrom($this->config['smtp']['from_email'], $this->config['smtp']['from_name']);
    }

    public function sendRegistrationEmail($to, $username) {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Welcome to Student Forum';
            
            $message = "
                <h2>Welcome to Student Forum!</h2>
                <p>Dear {$username},</p>
                <p>Thank you for registering with Student Forum. We're excited to have you join our community!</p>
                <p>You can now:</p>
                <ul>
                    <li>Create and participate in discussions</li>
                    <li>Share your knowledge with other students</li>
                    <li>Connect with peers from various fields</li>
                </ul>
                <p>If you have any questions, feel free to contact our support team.</p>
                <p>Best regards,<br>Student Forum Team</p>
            ";
            
            $this->mailer->Body = $message;
            $this->mailer->AltBody = strip_tags($message);
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
            return false;
        }
    }

    public function sendContactEmail($to, $subject, $message, $fromEmail, $fromName) {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            
            $this->mailer->Body = $message;
            $this->mailer->AltBody = strip_tags($message);
            
            // Add reply-to header
            $this->mailer->addReplyTo($fromEmail, $fromName);
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
            return false;
        }
    }
} 