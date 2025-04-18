<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION['user_id'])){
        $_SESSION["login_error"] = "You have to login to view question.";       
        header('Location: /student_forum/app/views/auth/login.php');
        exit;
    }
    
?>

<!-- Navigation bar -->
<?php include '../app/views/components/header.php'; ?>

<!-- New discussion modal -->
<?php include '../app/views/post/new_post.php' ?>

<div class="container">
    <div class="main-body p-0">
        <div class="inner-wrapper">
            <!-- Include sidebar component -->
            <?php include '../app/views/components/sidebar.php'; ?>
            
            <!-- Inner main -->
            <div class="inner-main">
                <!-- Include main header component -->
                <?php include '../app/views/components/main_header.php'; ?>

                <!-- Inner main body -->
                <div class="inner-main-body p-2 p-sm-3 forum-content fade-in">
                    <?php
                    if (!isset($postController)) {
                        require_once __DIR__ . '/../app/controllers/PostController.php';
                        $postController = new PostController();
                    }
                    
                    // Handle search
                    $searchTerm = '';
                    if (isset($_GET['search'])) {
                        $searchTerm = trim($_GET['search']);
                    }
                    
                    // Get user posts
                    $userPosts = $postController->getUserPost();
                    
                    // Filter posts if search term exists
                    if (!empty($searchTerm)) {
                        $filteredPosts = [];
                        foreach ($userPosts as $post) {
                            if (stripos($post['title'], $searchTerm) !== false || 
                                stripos($post['content'], $searchTerm) !== false) {
                                $filteredPosts[] = $post;
                            }
                        }
                        
                        // Show search results
                        echo '<div class="mb-3 p-3 bg-light rounded">';
                        echo '<strong><i class="fas fa-search mr-1"></i> Search Results:</strong> ' . 
                             count($filteredPosts) . ' discussion(s) found for "' . htmlspecialchars($searchTerm) . '"';
                        echo ' <a href="my_question.php" class="btn btn-sm btn-outline-secondary ml-2">
                                <i class="fas fa-times mr-1"></i>Clear
                               </a>';
                        echo '</div>';
                        
                        $posts = $filteredPosts;
                    } else {
                        $posts = $userPosts;
                    }

                    if (!empty($posts)) {
                        foreach ($posts as $post) {
                            include '../app/views/post/post_item.php';
                        }
                    } else {
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

<?php include '../app/views/components/footer.php'; ?> 