<?php
session_start();
?>

<?php include '../components/header.php'; ?>

    <style>
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            z-index: 10;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center">Login</h3>
                <form action="/student_forum/app/controllers/AuthController.php?action=login" method="POST">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="password-container">
                            <input type="password" name="password" id="password" class="form-control" required>
                            <span class="password-toggle" onclick="togglePassword()">
                                <i class="fa fa-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>

                <!-- Display alerts -->
                <?php include '../components/alerts.php'; ?>

                <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
    <?php include '../components/footer.php'; ?>
