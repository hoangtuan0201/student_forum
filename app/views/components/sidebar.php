<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
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
                <a href="/student_forum/public/index.php" class="nav-link nav-link-faded has-icon <?php echo ($current_page === 'index.php') ? 'active' : ''; ?>">
                    <i class="fas fa-home mr-2"></i>All Discussions
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/student_forum/public/my_question.php" class="nav-link nav-link-faded has-icon <?php echo ($current_page === 'my_question.php') ? 'active' : ''; ?>">
                    <i class="fas fa-user-edit mr-2"></i>My Discussions
                </a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
    <!-- /Inner sidebar body -->
</div>
<!-- /Inner sidebar --> 