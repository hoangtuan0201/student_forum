<?php
// This file receives the $posts array from the controller

// Display posts
if (!empty($posts)) {
    foreach ($posts as $post) {
        include ROOT_PATH . '/app/views/post/post_item.php';
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