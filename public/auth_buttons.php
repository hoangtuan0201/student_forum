<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .navbar {
            background-color: #007bff; /* Bootstrap primary blue */
        }
        .btn-primary {
            background-color: #007bff; /* Bootstrap primary blue */
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .card {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-control:focus {
            border-color: #007bff; /* Bootstrap primary blue */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Light blue shadow */
        }
    </style>
</head>
<body>

<!-- 🔹 Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <?php if (isset($_SESSION['username'])): ?>
            <span class="navbar-text mr-3">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="../app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Logout</a>
        <?php else: ?>
            <button class="btn btn-outline-light mr-2" data-toggle="modal" data-target="#loginModal">Login</button>
            <button class="btn btn-light" data-toggle="modal" data-target="#registerModal">Register</button>
        <?php endif; ?>
    </div>
</nav>



<!-- 🔹 Login Modal -->
<!-- The show class is used by Bootstrap to display the modal. -->
<div class="modal fade <?php if (isset($_SESSION['login_error'])) echo 'show'; ?>" 
id="loginModal" tabindex="-1" role="dialog" aria-hidden="true" style="<?php if (isset($_SESSION['login_error'])) echo 'display: block;'; ?>">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login to Student Forum</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="../app/controllers/AuthController.php?action=login" method="POST">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" id="login-password" name="password" class="form-control" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('login-password')">👁</button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <!-- Display error message if exists -->
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- 🔹 Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create an Account</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="../app/controllers/AuthController.php?action=register" method="POST">
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
                        <div class="input-group">
                            <input type="password" id="register-password" name="password" class="form-control" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('register-password')">👁</button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(id) {
        let input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }
</script>

</body>
</html>