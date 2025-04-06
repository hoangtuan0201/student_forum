<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION['user_id'])){
        $_SESSION["post_error"] = "You have to login to view question.";       
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    NEW DISCUSSION
                </button>
            </div>
            <!-- /Inner sidebar header -->

            <!-- Inner sidebar body -->
            <div class="inner-sidebar-body p-0">
                <div class="p-3 h-100" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: -16px;">
                        <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                    <div class="simplebar-content" style="padding: 16px;">
                                        <nav class="nav nav-pills nav-gap-y-1 flex-column">
                                            <a href="/student_forum/public/index.php" class="nav-link nav-link-faded has-icon ">All questions</a>
                                            <a href="/student_forum/public/my_question.php" class="nav-link nav-link-faded has-icon active">My question</a>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 234px; height: 292px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 151px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div>
                </div>
            </div>
            <!-- /Inner sidebar body -->
        </div>
        <!-- /Inner sidebar -->
        <!-- Inner main -->
        <div class="inner-main">
            
            <!-- Inner main header -->
            <div class="inner-main-header">
                <a class="nav-link nav-icon rounded-circle nav-link-faded mr-3 d-md-none" href="#" data-toggle="inner-sidebar"><i class="material-icons">arrow_forward_ios</i></a>
                <select class="custom-select custom-select-sm w-auto mr-1">
                    <option selected="">Latest</option>
                  
                </select>

                <span class="post-count ml-3"> 
                    <?php 
                        if (!isset($postController)) {
                            require_once __DIR__ . '/../app/controllers/PostController.php';
                            $postController = new PostController();
                        }
                        $posts = $postController->countAllPostsByUser($_SESSION['user_id']);
                        echo "$posts posts" 
                    ?>
                </span>



                <span class="input-icon input-icon-sm ml-auto w-auto">
                    <input type="text" class="form-control form-control-sm bg-gray-200 border-gray-200 shadow-none mb-4 mt-4" placeholder="Search forum" />
                </span>
            </div>
            
            <!-- /Inner main header -->
             

            <!-- Inner main body -->

            <!-- Forum List -->
            
            
            <div class="inner-main-body p-2 p-sm-3 collapse forum-content show">
                <?php
                if (!isset($postController)) {
                    require_once __DIR__ . '/../app/controllers/PostController.php';
                    $postController = new PostController();
                }
                $posts = $postController->getUserPost();

                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        include '../app/views/post/post_item.php';
                    }
                } else {
                    echo '<div class="alert alert-info text-center">No posts available.</div>';
                }
                ?>



            <!-- </div>
                <ul class="pagination pagination-sm pagination-circle justify-content-center mb-0">
                    <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
                    <li class="page-item active"><span class="page-link">2</span></li>
                    <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                    <li class="page-item">
                        <a class="page-link has-icon" href="javascript:void(0)"><i class="material-icons">next</i></a>
                    </li>
                </ul>
            </div> -->
            <!-- /Forum List -->




            <!-- /Inner main body -->
        </div>
        <!-- /Inner main -->
         
    </div>
</div>

<?php include '../app/views/includes/footer.php'; ?> 