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

<!-- nav bar -->
<?php include '../app/views/includes/header.php'; ?>
<!-- question modal after clicked new discussion -->
<?php include '../app/views/post/new_post.php' ?>

<div class="container">
    <div class="main-body p-0">
        <div class="inner-wrapper">
            <!-- Inner sidebar -->
            <div class="inner-sidebar">
                <!-- Inner sidebar header -->
                <div class="inner-sidebar-header justify-content-center">
                    <button class="btn btn-primary has-icon btn-block" type="button" data-toggle="modal" data-target="#questionModal">
                        <i class="fas fa-plus-circle mr-2"></i>
                        NEW DISCUSSION
                    </button>
                </div>
                <!-- /Inner sidebar header -->

                <!-- Inner sidebar body -->
                <div class="inner-sidebar-body p-0">
                    <div class="p-3">
                        <nav class="nav nav-pills nav-gap-y-1 flex-column">
                            <a href="/student_forum/public/index.php" class="nav-link nav-link-faded has-icon">
                                <i class="fas fa-home mr-2"></i>All Discussions
                            </a>
                            <a href="/student_forum/public/my_question.php" class="nav-link nav-link-faded has-icon active">
                                <i class="fas fa-user-edit mr-2"></i>My Discussions
                            </a>
                        </nav>
                    </div>
                </div>
                <!-- /Inner sidebar body -->
            </div>
            <!-- /Inner sidebar -->
            
            <!-- Inner main -->
            <div class="inner-main">
                <!-- Inner main header -->
                <div class="inner-main-header">
                    <div class="header-flex-container">
                        <!-- Left side: Post count -->
                        <div class="discussion-counter">
                            <?php 
                                if (!isset($postController)) {
                                    require_once __DIR__ . '/../app/controllers/PostController.php';
                                    $postController = new PostController();
                                }
                                $postCount = $postController->countAllPostsByUser($_SESSION['user_id']);
                            ?>
                            <i class="fas fa-clipboard-list text-primary mr-2"></i>
                            <span class="font-weight-bold mr-2"><?= $postCount ?></span> discussions
                        </div>
                        
                        <!-- Right side: Search box -->
                        <div class="search-wrapper">
                            <form method="GET" action="my_question.php">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search my discussions"
                                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                    >
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                
                    
                   
                </div>
                <!-- /Inner main header -->

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

<?php include '../app/views/includes/footer.php'; ?> 