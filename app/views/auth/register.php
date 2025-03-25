<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/student_forum/public/assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/student_forum/public/index.php">Student Forum</a>
    </div>
</nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center">Register</h3>
                <form action="/student_forum/app/controllers/AuthController.php?action=register" method="POST">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>

                <!-- Display registration errors -->
                <?php if (isset($_SESSION['register_error'])): ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
                    </div>
                <?php endif; ?>

                <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

</body>
</html>
