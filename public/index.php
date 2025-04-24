<?php
// Load all common includes in one place
require_once __DIR__ . '/../app/bootstrap.php';

// Load controllers
use App\Controllers\PostController;

?>

<!-- Navigation bar -->
<?php include ROOT_PATH . '/app/views/components/header.php'; ?>
    
<!-- New discussion modal -->
<?php include ROOT_PATH . '/app/views/post/new_post.php' ?>
    
<div class="container">
    <div class="main-body p-0"> 
        <div class="inner-wrapper">
            <!-- Include sidebar component -->
            <?php include ROOT_PATH . '/app/views/components/sidebar.php'; ?>
            
            <!-- Inner main -->
            <div class="inner-main">
                <!-- Include main header component -->
                <?php include ROOT_PATH . '/app/views/components/main_header.php'; ?>

                <!-- Include alerts component -->
                <?php include ROOT_PATH . '/app/views/components/alerts.php'; ?>

                <!-- Inner main body -->
                <div class="inner-main-body p-2 p-sm-3 forum-content fade-in">
                    <?php
                    // Create PostController instance
                    $postController = new PostController();
                    
                    // Get search terms and module filter if any
                    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                    $module_id = isset($_GET['module_id']) ? $_GET['module_id'] : '';
                    
                    // Get filtered posts based on search and module_id
                    $posts = $postController->getFilteredPosts($search, $module_id);
                    
                    // Display posts directly here
                    if (!empty($posts)) {
                        foreach ($posts as $post) {
                            include ROOT_PATH . '/app/views/post/post_item.php';
                        }
                    } else {
                        echo '<div class="text-center p-5 bg-white rounded shadow-sm">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <h5>No discussions found</h5>';
                        
                        if (!empty($search) || !empty($module_id)) {
                            echo '<p class="text-muted">No results match your search criteria.</p>
                                  <a href="index.php" class="btn btn-outline-secondary">Clear filters</a>';
                        } else {
                            echo '<p class="text-muted">Be the first to start a discussion!</p>
                                  <button class="btn btn-primary" data-toggle="modal" data-target="#questionModal">
                                     <i class="fas fa-plus-circle mr-1"></i> Create Discussion
                                  </button>';
                        }
                                
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/components/footer.php'; ?>
