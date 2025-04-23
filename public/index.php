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
                    
                    // Get posts for main page display
                    $posts = $postController->getAllPosts();
                    
                    // Include the posts list view which will use $posts variable
                    include ROOT_PATH . '/app/views/post/posts_list.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/components/footer.php'; ?>
