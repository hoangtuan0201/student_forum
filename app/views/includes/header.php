<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/student_forum/public/assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/student_forum/public/index.php">Student Forum</a>
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/student_forum/admin/index.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/student_forum/admin/users.php">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/student_forum/admin/posts.php">
                            <i class="fas fa-file-alt"></i> Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/student_forum/admin/modules.php">
                            <i class="fas fa-book"></i> Modules
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>

        <div>
            <?php if (isset($_SESSION['username'])): ?>
                <span class="navbar-text mr-3">
                    Welcome, <?php echo $_SESSION['username']; ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <span class="badge badge-warning">Admin</span>
                    <?php endif; ?>
                </span>
                <a href="/student_forum/app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Logout</a>
            <?php else: ?>
                <a href="/student_forum/app/views/auth/login.php" class="btn btn-outline-light mr-2">Login</a>
                <a href="/student_forum/app/views/auth/register.php" class="btn btn-light">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>