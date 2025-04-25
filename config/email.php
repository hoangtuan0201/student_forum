<?php
use PHPMailer\PHPMailer\PHPMailer;

$email = $_ENV['EMAIL'] ?? null;
$password = $_ENV['EMAIL_APP_PASSWORD'] ?? null;

if (empty($email) || empty($password)) {
    error_log('Email configuration is missing. Please set EMAIL and EMAIL_APP_PASSWORD in .env file.');
}

return [
    'smtp' => [
        'host' => 'smtp.gmail.com', // Your SMTP host
        'port' => 587,
        'username' => $email,
        'password' => $password,
        'encryption' => 'tls',
        'from_email' => $email, // Use the same email as username
        'from_name' => 'Student Forum',
        'send_as_user' => true // Cho phép hiển thị người gửi là người dùng
    ]
];
?>