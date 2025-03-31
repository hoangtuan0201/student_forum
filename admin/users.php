<?php
require_once '../app/controllers/AdminController.php';
$adminController = new AdminController();
$users = $adminController->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Student Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link rel="stylesheet" href="/student_forum/public/assets/css/styles.css">
</head>
<body>
    <?php include '../app/views/includes/header.php'; ?>
    
    <div class="container">
        <h1 class="h2 mb-4 mt-3">Manage Users</h1>
        
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
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['user_id']; ?></td>
                                    <td><?= htmlspecialchars($user['username']); ?></td>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <form action="/student_forum/app/controllers/AdminController.php?action=updateUserRole" method="post" class="d-inline">
                                            <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">
                                            <select name="role" class="form-control form-control-sm d-inline-block w-auto" 
                                                    onchange="this.form.submit()" 
                                                    <?= $user['user_id'] == $_SESSION['user_id'] ? 'disabled' : ''; ?>>
                                                <option value="student" <?= $user['role'] == 'student' ? 'selected' : ''; ?>>Student</option>
                                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td><?= date('M j, Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteUserModal<?= $user['user_id']; ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            
                                            <!-- Delete User Modal -->
                                            <div class="modal fade" id="deleteUserModal<?= $user['user_id']; ?>" 
                                                 tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete User</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this user?</p>
                                                            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
                                                            <p class="text-danger">This action cannot be undone. All posts and comments by this user will also be deleted.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <form action="/student_forum/app/controllers/AdminController.php?action=deleteUser" method="post">
                                                                <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">
                                                                <button type="submit" class="btn btn-danger">Delete User</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 