student_forum/
│── app/
│   ├── controllers/       # Xử lý logic (PHP)
│   │   ├── AuthController.php
│   │   ├── PostController.php
│   │   ├── CommentController.php
│   │   ├── ModuleController.php
│   │   ├── MessageController.php
│   │   ├── UserController.php
│   ├── models/            # Tương tác với Database (PHP)
│   │   ├── User.php
│   │   ├── Post.php
│   │   ├── Comment.php
│   │   ├── Module.php
│   │   ├── Message.php
│   ├── views/             # Giao diện (HTML, PHP)
│   │
│── config/ 


📌 Giải thích Folder Structure
1️⃣ app/ - Xử lý logic
controllers/ → Xử lý request từ người dùng.
models/ → Tương tác với Database.
views/ → Chứa giao diện trang web.
2️⃣ config/ - Cấu hình
database.php → Kết nối MySQL bằng PDO.
config.php → Các biến môi trường (base URL, tên site...).

4️⃣ public/ - File có thể truy cập từ trình duyệt
index.php → Điểm vào của ứng dụng (Front Controller).
assets/ → Chứa hình ảnh, CSS, JS.
5️⃣ routes/ - Điều hướng URL
web.php → Define các route, ví dụ:
