# Forum Website Structure & Features

## Overview
This forum website is designed to help students post questions related to their coursework and receive assistance. The platform provides CRUD (Create, Read, Update, Delete) functionalities for posts, users, and modules while maintaining structured relationships using a MySQL database with PHP PDO.

## Application Flow

### 1. Authentication
- **Sign Up:** Users create an account by providing a username, email, and password.
- **Sign In:** Users log in to access the forum.
- **Session Management:** Once authenticated, users are redirected to the forum page.
- **Logout:** Users can log out to end their session.

### 2. Forum Page
- **Displays a list of all posts** with:
  - Post title
  - Content
  - Associated module
  - Author's name
  - Image (if uploaded)
  - Number of comments
  - Timestamp
- **Post interactions:**
  - Users can click on a post to view details and comments.
  - Users can create a new post with a title, content, and an optional image.
  - Users can edit or delete their own posts.

### 3. Post Management
- **Create Post:** Users can submit a post with a title, content, optional image, and select the module.
- **Edit Post:** Users can modify their own posts.
- **Delete Post:** Users can remove their posts.
- **Image Upload:** Each post can contain an image that gets stored in the database.

### 4. Comments System
- Users can add comments to posts.
- Comments are listed under the respective post.
- Users can delete their own comments.

### 5. Module Management (Admin Feature)
- Admin can add new modules.
- Admin can edit existing module names.
- Admin can delete modules.

### 6. User Management
- Users can update their profile information.
- Admin can add, edit, and delete users.
- Users can reset their passwords.

### 7. Admin Contact Form
- A contact form allows users to send messages to the admin.
- Messages are stored in the messages table.
- Admin can view and respond to messages.

## Database Structure
### 1. users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 2. modules Table
```sql
CREATE TABLE modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
);
```

### 3. posts Table
```sql
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    user_id INT,
    module_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE SET NULL
);
```

### 4. comments Table
```sql
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    user_id INT,
    post_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
```

### 5. messages Table
```sql
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Technologies Used
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP with PDO
- **Database:** MySQL
- **Authentication:** PHP session management
- **UI Framework (Optional):** Bootstrap for styling

## Future Enhancements
- **Search Functionality:** Allow users to search for posts by keyword.
- **Email Notifications:** Notify users when someone comments on their post.

## Conclusion
This document provides a detailed breakdown of the forum website, covering authentication, CRUD operations, database structure, and potential future improvements. Developers should follow this guide to implement and enhance the system efficiently.

