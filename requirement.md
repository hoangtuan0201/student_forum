Student Forum - Web Programming Project
Overview
This project is a prototype system where students can post questions amongst themselves to get help with their coursework. It functions as a simple self-contained student version of Stack Overflow.
Features
Core Features (Implemented)
User Authentication: Login system for students
Post Management: Create, read, update, and delete posts
Comment System: Add, edit, and delete comments on posts
Module Organization: Posts categorized by modules/courses
Planned Features
User Management: Complete CRUD operations for user accounts
Module Management: Admin interface for managing course modules
Contact Form: Email functionality to contact administrators
Admin Dashboard: Special interface for administrators
Registration System: Allow students to create accounts
Password Encryption: Enhanced security for user credentials
Input Validation: Client and server-side validation
UI/UX Improvements: Enhanced user interface design
Pagination: For post and comment listings
Search Functionality: Find posts by keywords
Notifications: Success/error messages for user actions
Technical Implementation
Architecture
Model-View-Controller (MVC) pattern for clean code organization
PHP PDO for database operations with prepared statements
MySQL relational database for data storage
Responsive Design using Bootstrap framework
Database Structure
Users: Store user information and credentials
Posts: Store questions/discussions created by users
Comments: Store responses to posts
Modules: Store course/module information
Security Measures
Prepared statements to prevent SQL injection
Input sanitization to prevent XSS attacks
Authentication checks for protected operations
Form validation for data integrity
Installation and Setup
Clone the repository to your web server directory
Import the database schema from database/schema.sql
Configure database connection in config/database.php
4. Ensure your web server has PHP 7.4+ and MySQL 5.7+
Usage
For Students
Login with your credentials
Browse questions by module
Post new questions
Comment on existing questions
Edit or delete your own posts and comments
For Administrators
Manage users, posts, and modules
Monitor system activity
Respond to contact form submissions
Development Roadmap
Phase 1 (Current)
Core authentication
Basic CRUD for posts and comments
Simple UI implementation
Phase 2 (Next Steps)
Complete user management
Module management
Contact form implementation
Enhanced security features
Phase 3 (Future Enhancements)
Advanced search functionality
Real-time notifications
User profile customization
Performance optimizations
Testing
Functional testing for all CRUD operations
Cross-browser compatibility testing
Mobile responsiveness testing
Security vulnerability testing
Legal and Ethical Considerations
GDPR compliance for user data
Accessibility standards (WCAG 2.1)
Content ownership policies
Code of conduct for user interactions
Contributors
[Your Name] - Lead Developer
License
This project is developed as part of COMP1841 Web Programming coursework and is not licensed for public distribution.
---
This README serves as documentation for the Student Forum project developed for COMP1841 Web Programming coursework (2023/24).