<?php
// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="/student_forum/admin/users.php" 
                           class="btn <?= $current_page === 'users.php' ? 'btn-primary' : 'btn-outline-primary' ?> btn-block mb-3">
                            <i class="fas fa-user-plus"></i> Manage Users
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/student_forum/admin/posts.php" 
                           class="btn <?= $current_page === 'posts.php' ? 'btn-success' : 'btn-outline-success' ?> btn-block mb-3">
                            <i class="fas fa-edit"></i> Manage Posts
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/student_forum/admin/modules.php" 
                           class="btn <?= $current_page === 'modules.php' ? 'btn-info' : 'btn-outline-info' ?> btn-block mb-3">
                            <i class="fas fa-book"></i> Manage Modules
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/student_forum/public/index.php" 
                           class="btn btn-outline-secondary btn-block mb-3">
                            <i class="fas fa-home"></i> View Forum
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>