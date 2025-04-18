<?php
if (!isset($postController)) {
    require_once __DIR__ . '/../../controllers/PostController.php';
    $postController = new PostController();
}

$current_page = basename($_SERVER['PHP_SELF']);
$postCount = ($current_page === 'my_question.php') 
    ? $postController->countAllPostsByUser($_SESSION['user_id'])
    : $postController->countAllPosts();

$searchPlaceholder = ($current_page === 'my_question.php') 
    ? "Search my discussions"
    : "Search discussions";
?>

<div class="inner-main-header">
    <div class="header-flex-container">
        <!-- Left side: Post count -->
        <div class="discussion-counter">
            <i class="fas fa-clipboard-list text-primary mr-2"></i>
            <span class="font-weight-bold mr-2"><?= $postCount ?></span> discussions
        </div>
        
        <!-- Right side: Search box -->
        <div class="search-wrapper">
            <form method="GET" action="<?php echo $current_page; ?>">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" 
                           placeholder="<?php echo $searchPlaceholder; ?>"
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