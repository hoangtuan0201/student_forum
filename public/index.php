
<!-- Navigation bar -->
<?php include '../app/views/includes/header.php'; ?>
    
<!-- New discussion modal -->
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
                            <a href="index.php" class="nav-link nav-link-faded has-icon active">
                                <i class="fas fa-home mr-2"></i>All Discussions
                            </a>
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="/student_forum/public/my_question.php" class="nav-link nav-link-faded has-icon">
                                <i class="fas fa-user-edit mr-2"></i>My Discussions
                            </a>
                            <?php endif; ?>
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
                                $postCount = $postController->countAllPosts();
                            ?>
                            <i class="fas fa-clipboard-list text-primary mr-2"></i>
                            <span class="font-weight-bold mr-2"><?= $postCount ?></span> discussions
                        </div>
                        
                        <!-- Right side: Search box -->
                        <div class="search-wrapper">
                            <form method="GET" action="index.php">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search discussions"
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

                <!-- Alert sections -->
                <div class="px-3">
                    <!-- Error Display Section -->
                    <?php if (isset($_SESSION['post_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['post_error']; unset($_SESSION['post_error']); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- Success Display Section -->
                    <?php if (isset($_SESSION['register_success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['register_success']; unset($_SESSION['register_success']); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Inner main body -->
                <div class="inner-main-body p-2 p-sm-3 forum-content fade-in">
                    <?php
                    if (!isset($postController)) {
                        require_once __DIR__ . '/../app/controllers/PostController.php';
                        $postController = new PostController();
                    }

                    // Get search term from URL parameter (if exists)
                    $searchTerm = '';
                    if(isset($_GET['search'])) {
                        $searchTerm = trim($_GET['search']);
                    }
                    
                    // Check if user is searching
                    if (!empty($searchTerm)) {
                        // Get filtered posts matching the search term
                        $postResults = $postController->searchPosts($searchTerm);
                        
                        // Show search results information
                        echo '<div class="mb-3 p-3 bg-light rounded">';
                        echo '<strong><i class="fas fa-search mr-1"></i> Search Results:</strong> ' . 
                             count($postResults) . ' discussion(s) found for "' . htmlspecialchars($searchTerm) . '"';
                        echo ' <a href="index.php" class="btn btn-sm btn-outline-secondary ml-2">
                                <i class="fas fa-times mr-1"></i>Clear
                               </a>';
                        echo '</div>';
                        
                        // Use the search results for display
                        $posts = $postResults;
                    } else {
                        // No search, get all posts
                        $posts = $postController->getAllPosts();
                    }

                    // Display posts
                    if (!empty($posts)) {
                        foreach ($posts as $post) {
                            include '../app/views/post/post_item.php';
                        }
                    } else {
                        echo '<div class="text-center p-5 bg-white rounded shadow-sm">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <h5>No discussions found</h5>
                                <p class="text-muted">Be the first to start a discussion!</p>
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
