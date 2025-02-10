Student Forum - PHP/MySQL CRUD System

Project Overview

This project is a Student Forum System where students can post questions related to coursework. The system is built using PHP (PDO), MySQL, and MVC architecture.

Features

User Authentication: Students can register, log in, and manage their accounts.

Post Management: Users can create, edit, delete, and view questions.

Module Assignment: Each post is linked to a module.

Image Upload: Students can upload screenshots or images with their posts.

Comment System: Users can comment on posts.

Admin Features: Admins can manage users, posts, and modules.

Folder Structure

project-folder/
│── app/
│   ├── controllers/   # Handles requests
│   ├── models/        # Database logic
│   ├── views/         # HTML templates
│── config/
│   ├── database.php   # Database connection
│── public/
│   ├── assets/        # CSS, JS, images
│── index.php          # Entry point
│── README.md          # Project documentation

Installation Guide

Install XAMPP or MAMP (for local development).

Clone this repository into your server directory (htdocs or www).

Import the student_forum.sql file into MySQL.

Update config/database.php with your database credentials.

Start Apache and MySQL, then open http://localhost/project-folder/ in your browser.

Database Schema

users: Stores user details.

modules: Stores module names.

posts: Stores student questions.

comments: Stores comments on posts.

messages: store messages.

Technologies Used

PHP (PDO for secure database interaction)

MySQL

HTML, CSS, JavaScript

Bootstrap (for UI design)

License

This project is for educational purposes only. Feel free to modify and improve it.

Contact

For any issues, contact your-email@example.com.

