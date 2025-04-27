# Student Forum Documentation

## System Overview
The Student Forum is a PHP-based web application that provides a discussion platform for students. It follows an MVC (Model-View-Controller) architecture with a MySQL database backend.

## Project Structure

```
student_forum/
├── admin/                    # Admin dashboard files
│   ├── index.php             # Admin main dashboard
│   ├── users.php             # User management
│   ├── posts.php             # Post management
│   ├── modules.php           # Module management
│   └── styles.css            # Admin-specific styles
├── app/                      # Application core
│   ├── bootstrap.php         # Application initialization
│   ├── controllers/          # Handle user requests
│   │   ├── AuthController.php    # User authentication
│   │   ├── PostController.php    # Post management
│   │   ├── CommentController.php # Comment operations
│   │   └── AdminController.php   # Admin functionality
│   ├── models/               # Database interaction
│   │   ├── User.php          # User data operations
│   │   ├── Post.php          # Post data operations
│   │   ├── Comment.php       # Comment data operations
│   │   ├── Module.php        # Module data operations
│   │   └── Email.php         # Email functionality
│   └── views/                # UI templates
│       ├── auth/             # Authentication pages
│       ├── components/       # Reusable UI components
│       ├── pages/            # Main pages
│       └── post/             # Post-related views
├── config/                   # Configuration
│   └── database.php          # Database connection
├── public/                   # Publicly accessible files
│   ├── assets/               # Static resources
│   │   ├── css/              # Stylesheets
│   │   ├── js/               # JavaScript files
│   │   └── images/           # Image resources
│   ├── uploads/              # User-uploaded content
│   └── index.php             # Main entry point
├── vendor/                   # Composer dependencies
├── .env                      # Environment variables
├── composer.json             # Dependency management
├── student_forum.sql         # Database schema
└── README.md                 # Project documentation
```

## Technologies Used
- PHP 7.4+ (Backend language)
- MySQL (Database)
- PDO (Database connection)
- HTML/CSS/JavaScript (Frontend)
- Composer (Dependency management)

## Core Features
1. **User Authentication**
   - Registration, login, logout
   - Role-based access control (student/admin)

2. **Discussion Forum**
   - Create, read, update, and delete posts
   - Comment on posts
   - Search functionality
   - Filter posts by modules

3. **Admin Dashboard**
   - User management
   - Post moderation
   - Module management

## Database Structure
The application uses a MySQL database with the following key tables:
- `users`: Store user information and credentials
- `posts`: Discussion posts created by users
- `comments`: User comments on posts
- `modules`: Different subject areas for categorizing posts

## Application Flow
1. The application entry point is `public/index.php`
2. `bootstrap.php` initializes core requirements
3. Controllers handle user requests
4. Models interact with the database
5. Views render HTML to the user

## Setup Instructions
1. Place the project in a web server directory (e.g., XAMPP htdocs folder)
2. Create a MySQL database named "student_forum"
3. Import the `student_forum.sql` file to set up the database schema
4. Update database credentials in `.env` or `config/database.php`
5. Access the forum via `http://localhost/student_forum`

## Security Features
- Password hashing for user credentials
- Prepared statements to prevent SQL injection
- Input validation and sanitization
- Role-based access control

## Dependencies
- Composer packages (managed via composer.json)
- PHP PDO extension for database connectivity
- PHP dotenv for environment variable management



