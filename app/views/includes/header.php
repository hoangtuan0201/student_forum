<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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
                        <a class="nav-link" href="/student_forum/admin/index.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/student_forum/admin/users.php">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/student_forum/admin/posts.php">
                            <i class="fas fa-file-alt"></i> Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/student_forum/admin/modules.php">
                            <i class="fas fa-book"></i> Modules
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>

        <div>
            <?php if (isset($_SESSION['username'])): ?>
                <span class="navbar-text mr-3">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
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