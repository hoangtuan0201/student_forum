<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load autoloader
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap.php';
// Check if user is admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: /student_forum/public/index.php");
    exit;
}

use App\Models\Post;
use App\Models\User;
use App\Models\Module;

$postModel = new Post();
$userModel = new User();
$moduleModel = new Module();

// Handle post creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_post"])) {
    // User and module are required for admin
    $user_id = $_POST["user_id"] ?? null;
    $module_id = $_POST["module_id"] ?? null;
    $title = htmlspecialchars(trim($_POST["title"]));
    $content = htmlspecialchars(trim($_POST["content"]));
    $image_path = null;
    
    // Validate all fields
    if (empty($title) || empty($content) || empty($user_id) || empty($module_id)) {
        $_SESSION["error_message"] = "All fields are required.";
    } else {
        // Handle image upload if present
        if (!empty($_FILES["image"]["name"])) {
            // Validate file type
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            $file_type = $_FILES["image"]["type"];
            
            if (!in_array($file_type, $allowed_types)) {
                $_SESSION["error_message"] = "Only JPG, JPEG, and PNG files are allowed.";
            } else {
                if (!file_exists(UPLOAD_PATH)) {
                    mkdir(UPLOAD_PATH, 0777, true);
                }
                
                $image_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = UPLOAD_PATH . $image_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = UPLOAD_URL . $image_name;
                } else {
                    $_SESSION["error_message"] = "Failed to upload image.";
                }
            }
        }
        
        // If no error so far, create the post
        if (!isset($_SESSION["error_message"])) {
            if ($postModel->createPost($user_id, $module_id, $title, $content, $image_path)) {
                $_SESSION["success_message"] = "Post created and assigned successfully!";
                header("Location: /student_forum/admin/posts.php");
                exit;
            } else {
                $_SESSION["error_message"] = "Failed to create post.";
            }
        }
    }
}

// Get all users and modules for dropdown
$users = $userModel->getAllUsers();
$modules = $moduleModel->getAllModules();

// Include header
include_once __DIR__ . '/../components/header.php';
?>

<div class="container mt-4">
    <h2>Create New Post</h2>
    <p class="text-muted">Create a post and assign it to a user and module.</p>
    
    <!-- Include alerts component -->
    <?php include_once __DIR__  . '/../components/alerts.php'; ?>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="title">Post Title:</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                
                <div class="form-group mb-3">
                    <label for="content">Post Content:</label>
                    <textarea name="content" id="content" class="form-control" rows="6" required></textarea>
                </div>
                
                <div class="form-group mb-3">
                    <label for="user_id">Assign to User:</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Select User</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user["user_id"]; ?>">
                                <?php echo htmlspecialchars($user["username"]); ?> (<?php echo $user["email"]; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label for="module_id">Assign to Module:</label>
                    <select name="module_id" id="module_id" class="form-control" required>
                        <option value="">Select Module</option>
                        <?php foreach ($modules as $module): ?>
                            <option value="<?php echo $module["module_id"]; ?>">
                                <?php echo htmlspecialchars($module["module_name"]); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label for="image">Image (Optional):</label>
                    <input type="file" name="image" id="image" class="form-control">
                    <small class="text-muted">Supported formats: JPG, JPEG, PNG</small>
                </div>
                
                <button type="submit" name="create_post" class="btn btn-primary">Create Post</button>
            </form>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../components/footer.php'; ?> 