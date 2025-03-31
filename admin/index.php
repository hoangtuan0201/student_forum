<?php
require_once '../app/controllers/AdminController.php';
$adminController = new AdminController();
$stats = $adminController->getDashboardStats();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Student Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous">

    <link rel="stylesheet" href="/student_forum/public/assets/css/styles.css">
    
</head>
<body>
    <?php include '../app/views/includes/header.php'; ?>
    
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
        
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="users.php" class="btn btn-outline-primary btn-block mb-3">
                                    <i class="fas fa-user-plus"></i> Manage Users
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="posts.php" class="btn btn-outline-success btn-block mb-3">
                                    <i class="fas fa-edit"></i> Manage Posts
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="modules.php" class="btn btn-outline-info btn-block mb-3">
                                    <i class="fas fa-book"></i> Manage Modules
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="../public/index.php" class="btn btn-outline-secondary btn-block mb-3">
                                    <i class="fas fa-home"></i> View Forum
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
