<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION['user_id'])){
        $_SESSION["login_error"] = "You have to login to view question.";       
        header('Location: /student_forum/app/views/auth/login.php');
        exit;
    }
    
    // Load autoloader
    require_once __DIR__ . '/../../../vendor/autoload.php';
    
    // Import the PostController class
    use App\Controllers\PostController;
?>

<!-- Navigation bar -->
<?php include '../components/header.php'; ?>

<!-- New discussion modal -->
<?php include '../post/new_post.php' ?>

<div class="container">
    <div class="main-body p-0">
        <div class="inner-wrapper">
            <!-- Include sidebar component -->
            <?php include '../components/sidebar.php'; ?>
            
            <!-- Inner main -->
            <div class="inner-main">
                <!-- Include main header component -->
                <?php include '../components/main_header.php'; ?>

                <!-- Inner main body -->
                <div class="inner-main-body p-2 p-sm-3 forum-content fade-in">
                    <?php
                    if (!isset($postController)) {
                        $postController = new PostController();
                    }
                    
                    // Always get the posts belonging to the current user
                    $posts = $postController->getUserPost();

                    // Display posts
                    if (!empty($posts)) {
                        foreach ($posts as $post) {
                            include '../post/post_item.php';
                        }
                    } else { // User has no posts
                        echo '<div class="text-center p-5 bg-white rounded shadow-sm">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <h5>No discussions found</h5>
                                <p class="text-muted">You haven\'t created any discussions yet.</p>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#questionModal">
                                    <i class="fas fa-plus-circle mr-1"></i> Create Discussion
                                </button>
                              </div>';
                    }
                    ?>
                </div>
                <!-- /Inner main body -->
            </div>
            <!-- /Inner main -->
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?> 