<?php
require_once '../app/controllers/AdminController.php';
$adminController = new AdminController();
$stats = $adminController->getDashboardStats();
?>

<?php include '../app/views/components/header.php'; ?>

    
    <div class="container">
        <h1 class="h2 mb-4 mt-3">Admin Dashboard</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Users</h5>
                                <h2 class="display-4"><?= $stats['total_users']; ?></h2>
                            </div>
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                        <a href="users.php" class="text-white">View all users &rarr;</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card text-white bg-success mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Posts</h5>
                                <h2 class="display-4"><?= $stats['total_posts']; ?></h2>
                            </div>
                            <i class="fas fa-file-alt fa-3x"></i>
                        </div>
                        <a href="posts.php" class="text-white">View all posts &rarr;</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card text-white bg-info mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Modules</h5>
                                <h2 class="display-4"><?= $stats['total_modules']; ?></h2>
                            </div>
                            <i class="fas fa-book fa-3x"></i>
                        </div>
                        <a href="modules.php" class="text-white">View all modules &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
        

       <?php include '../app/views/components/footer.php'; ?>
