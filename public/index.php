<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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

                <!-- Include alerts component -->
                <?php include '../app/views/components/alerts.php'; ?>

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
                    
                    // Get module filter parameter
                    $moduleFilter = isset($_GET['module_id']) ? $_GET['module_id'] : '';
                    
                    // Determine if any filters are active
                    $isFiltering = !empty($searchTerm) || !empty($moduleFilter);
                    
                    $posts = [];
                    
                    // Check if user is searching or filtering
                    if ($isFiltering) {
                        // Get filtered posts
                        $posts = $postController->getFilteredPosts($searchTerm, $moduleFilter);
                        
                        // Show filter information bar
                        echo '<div class="mb-3 p-3 bg-light rounded d-flex justify-content-between align-items-center">';
                        
                        // Left side - filter summary
                        echo '<div><strong><i class="fas fa-filter mr-1"></i> Showing:</strong> ';
                        
                        $filterLabels = [];
                        if (!empty($searchTerm)) {
                            $filterLabels[] = 'Search for "' . htmlspecialchars($searchTerm) . '"';
                        }
                        if (!empty($moduleFilter)) {
                            // Get module name
                            require_once __DIR__ . '/../app/models/Module.php';
                            $moduleModel = new Module();
                            $module = $moduleModel->getModuleById($moduleFilter);
                            if ($module) {
                                $filterLabels[] = 'Module: ' . htmlspecialchars($module['module_name']);
                            }
                        }
                        
                        echo implode(' | ', $filterLabels);
                        echo ' (' . count($posts) . ' results)';
                        echo '</div>';
                        
                        // Right side - clear button
                        echo '<a href="index.php" class="btn btn-sm btn-outline-secondary">
                               <i class="fas fa-times mr-1"></i>Clear All
                              </a>';
                        
                        echo '</div>';
                    } else {
                        // No search or filters, get all posts
                        $posts = $postController->getAllPosts();
                    }

                    // Display posts
                    if (!empty($posts)) {
                        foreach ($posts as $post) {
                            include '../app/views/post/post_item.php';
                        }
                    } elseif (!$isFiltering) {
                        echo '<div class="text-center p-5 bg-white rounded shadow-sm">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <h5>No discussions found</h5>
                                <p class="text-muted">Be the first to start a discussion!</p>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#questionModal">
                                    <i class="fas fa-plus-circle mr-1"></i> Create Discussion
                                </button>
                              </div>';
                    } else {
                        // Show no results for search/filter
                        echo '<div class="text-center p-5 bg-white rounded shadow-sm">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h5>No matching discussions found</h5>
                                <p class="text-muted">Try adjusting your search or filter criteria</p>
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
