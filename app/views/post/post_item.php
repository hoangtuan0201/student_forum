<div class="card mb-2 shadow-sm">
    <div class="card-body p-2 p-sm-3">
        <div class="media forum-item">
            <div class="media-body">
                <h6>
                    <a href="/student_forum/app/views/post/post_detail.php?id=<?= $post['post_id']; ?>" class="text-body font-weight-bold"><?= htmlspecialchars($post["title"]); ?></a>
                </h6>
                <p class="text-secondary">
                    <?= htmlspecialchars(substr($post["content"], 0, 50)) . (strlen($post["content"]) > 50 ? '...' : ''); ?>
                </p>
                
                <p class="text-muted mt-2 small">   
                    <a href="#" class="font-weight-bold"><?= htmlspecialchars($post["username"]); ?></a> 
                    posted in <strong><?= htmlspecialchars($post["module_name"]); ?></strong>
                    <span class="text-secondary"> · <?= date('M j, Y', strtotime($post["created_at"])); ?></span>
                </p>
                
                <?php
                // Đếm số lượng comment cho bài viết này
                require_once __DIR__ . '/../../controllers/CommentController.php';
                $commentController = new CommentController();
                $commentCount = $commentController->countCommentsByPostId($post['post_id']);
                ?>
                <p class="text-muted small">
                    <i class="far fa-comment-alt"></i> <?= $commentCount ?> comments
                </p>
                
                <div class="text-right">
<<<<<<< HEAD
                <a href="/student_forum/app/views/post/post_detail.php?id=<?= $post['post_id']; ?>" class="btn btn-sm btn-outline-primary">Read more</a>

                    <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $post["user_id"]) : ?>
                        
                        <form method="POST" action="/student_forum/app/controllers/PostController.php?action=delete_post" style="display: inline;">
                            <input type="hidden" name="post_id" value="<?= $post["post_id"]; ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                    onclick="return confirm('Are you sure you want to delete this post?')">Delete
                            </button>
                        </form>
                        
                    <?php endif ?>
                    
=======
                    <a href="/student_forum/app/views/post/post_detail.php?id=<?= $post['post_id']; ?>" class="btn btn-sm btn-outline-primary">Read more</a>
>>>>>>> e4d2bd746c442ec95dbf71609c8a27b97cdcac32
                </div>
            </div>
        </div>
    </div>
</div>