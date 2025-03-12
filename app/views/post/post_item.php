<div class="card mb-2 shadow-sm">
    <div class="card-body p-2 p-sm-3">
        <div class="media forum-item">
            <div class="media-body">
                <h6>
                    <a href="post_detail.php?id=<?= $post['post_id']; ?>" class="text-body font-weight-bold"><?= htmlspecialchars($post["title"]); ?></a>
                </h6>
                <p class="text-secondary">
                    <?= htmlspecialchars(substr($post["content"], 0, 50)) . (strlen($post["content"]) > 50 ? '...' : ''); ?>
                </p>
                
                <p class="text-muted mt-2 small">   
                    <a href="#" class="font-weight-bold"><?= htmlspecialchars($post["username"]); ?></a> 
                    posted in <strong><?= htmlspecialchars($post["module_name"]); ?></strong>
                    <span class="text-secondary"> · <?= date('M j, Y', strtotime($post["created_at"])); ?></span>
                </p>
                
                <div class="text-right">
                    <a href="/student_forum/app/views/post/post_detail.php?id=<?= $post['post_id']; ?>" class="btn btn-sm btn-outline-primary">Read more</a>
                </div>
            </div>
        </div>
    </div>
</div>