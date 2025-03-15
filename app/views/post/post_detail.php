<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../public/assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        .post-content img {
            width: 688px;
            height: 474px;
            object-fit: contain;
            max-width: 100%;
        }
    </style>
</head>
<?php

require_once __DIR__ . '/../../controllers/PostController.php';
require_once __DIR__ . '/../../controllers/CommentController.php';

// Kiểm tra ID bài viết
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /');
    exit();
}

$post_id = $_GET['id'];
$postController = new PostController();
$post = $postController->getPostById($post_id);

// Kiểm tra bài viết tồn tại
if (!$post) {
    header('Location: /');
    exit();
}

// Lấy comments
$commentController = new CommentController();
$comments = $commentController->getCommentsByPostId($post_id);

// Include header
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title"><?= htmlspecialchars($post["title"]); ?></h3>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <span class="text-muted">Posted by </span>
                            <a href="#" class="font-weight-bold"><?= htmlspecialchars($post["username"]); ?></a>
                            <span class="text-muted"> in </span>
                            <span class="badge badge-secondary"><?= htmlspecialchars($post["module_name"]); ?></span>
                            <span class="text-muted"> · <?= date('F j, Y, g:i a', strtotime($post["created_at"])); ?></span>
                        </div>
                    </div>
                    
                    <div class="post-content mb-4">
                        <p><?= nl2br(htmlspecialchars($post["content"])); ?></p>
                        
                        <?php if (!empty($post["image"])): ?>
                            <div class="mt-3">
                                <img width="688" height="474" src="/student_forum/<?= htmlspecialchars($post["image"]); ?>" class="img-fluid rounded" alt="Post Image">
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <hr>
                    
                    <!-- Comment Section -->
                    <div class="comments-section">
                        <h5 class="mb-3">Comments (<?= count($comments); ?>)</h5>
                        
                        <!-- Display comments -->
                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment mb-3 p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong><?= htmlspecialchars($comment['username']); ?></strong>
                                            <small class="text-muted ml-2"><?= date('M j, Y g:i a', strtotime($comment['created_at'])); ?></small>
                                        </div>
                                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
                                            <div>
                                                <form action="/student_forum/app/comment_handler.php" method="post" class="d-inline">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="comment_id" value="<?= $comment['comment_id']; ?>">
                                                    <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mt-2">
                                        <?= nl2br(htmlspecialchars($comment['content'])); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No comments yet. Be the first to comment!</p>
                        <?php endif; ?>
                        
                        <!-- Comment Form -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="comment-form mt-4">
                                <h6>Add a Comment</h6>
                                <form action="/student_forum/app/comment_handler.php" method="post">
                                    <input type="hidden" name="action" value="create">
                                    <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                                    <div class="form-group">
                                        <textarea class="form-control" name="content" rows="3" placeholder="Write your comment here..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mt-4">
                                Please <a href="/student_forum/login.php">login</a> to comment.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="/student_forum/public/index.php  " class="btn btn-outline-secondary">&larr; Back to Discussions</a>
            </div>
        </div>
    </div>
</div>

