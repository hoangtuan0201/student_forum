<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/student_forum/public/index.php">Student Forum</a>
        <div>
            <?php if (isset($_SESSION['username'])): ?>
                <span class="navbar-text mr-3">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="/student_forum/app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Logout</a>
            <?php else: ?>
                <a href="/student_forum/app/views/auth/login.php" class="btn btn-outline-light mr-2">Login</a>
                <a href="/student_forum/app/views/auth/register.php" class="btn btn-light">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>