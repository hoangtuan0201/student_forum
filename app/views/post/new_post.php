<?php
include_once __DIR__ . '/../../../config/database.php'; 

$database = new Database();
$pdo = $database->connect();
?>

<!-- New Question Modal -->
<div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="../app/controllers/PostController.php?action=create_post" method="POST" enctype="multipart/form-data">
                <div class="modal-header d-flex align-items-center bg-primary text-white">
                    <h6 class="modal-title mb-0" id="questionModalLabel">New Discussion</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Title Input -->
                    <div class="form-group">
                        <label for="questionTitle">Title</label>
                        <input type="text" class="form-control" id="questionTitle" name="title" placeholder="Enter title" required />
                    </div>

                    <!-- Module Selection -->
                    <div class="form-group">
                        <label for="moduleSelect">Select Module</label>
                        <select class="form-control" id="moduleSelect" name="module_id" required>
                            <option value="">Select Module</option>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM modules");
                            while ($module = $stmt->fetch()) {
                                echo "<option value='{$module["module_id"]}'>{$module["module_name"]}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Content Input -->
                    <div class="form-group">
                        <label for="questionContent">Content</label>
                        <textarea class="form-control" id="questionContent" name="content" rows="4" placeholder="Write your question here..." required></textarea>
                    </div>

                    <!-- File Upload -->
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="image" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-text text-muted">Only JPG, JPEG, and PNG files are allowed.</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
