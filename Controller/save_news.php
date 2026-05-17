<?php
session_start();
require_once __DIR__ . "/../Database/Database.php";

// Bật hiển thị lỗi để dễ dàng debug nếu phát sinh vấn đề trên host
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new Database();

// ĐÃ SỬA: Gom ảnh đại diện bài viết vào riêng thư mục con covers/
$uploadDir = "../public/uploads/cover/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* 1. LẤY ID USER ĐANG ĐĂNG NHẬP */
$author_id = $_SESSION['id'] ?? null;
if (!$author_id) {
    die("Bạn chưa đăng nhập hoặc phiên làm việc đã hết hạn.");
}

/* 2. XỬ LÝ UPLOAD ẢNH COVER (ẢNH ĐẠI DIỆN BÀI VIẾT) */
$cover = ""; // Biến lưu đường dẫn ảnh cover vào DB

if (isset($_FILES['cover_file']) && $_FILES['cover_file']['error'] === UPLOAD_ERR_OK) {

    // Giới hạn dung lượng file ảnh cover (Ví dụ: tối đa 3MB để tránh quá tải host)
    $maxFileSize = 3 * 1024 * 1024;
    if ($_FILES['cover_file']['size'] > $maxFileSize) {
        die("Lỗi: File ảnh cover quá lớn (Vui lòng chọn ảnh dưới 3MB).");
    }

    // Kiểm tra định dạng file
    $ext = strtolower(pathinfo($_FILES['cover_file']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allowed)) {
        die("Lỗi: Ảnh cover không đúng định dạng (Chỉ chấp nhận JPG, PNG, GIF, WEBP).");
    }

    // Đặt tên file ngẫu nhiên để tránh trùng lặp đè file cũ
    $filename = time() . "_" . uniqid() . "." . $ext;

    if (move_uploaded_file($_FILES['cover_file']['tmp_name'], $uploadDir . $filename)) {
        // ĐÃ SỬA: Thêm đường dẫn covers/ để lưu chuẩn vào Database
        $cover = "public/uploads/cover/" . $filename;
    } else {
        die("Lỗi: Không thể lưu file ảnh cover vào thư mục uploads.");
    }
} else {
    die("Lỗi: Bạn chưa chọn ảnh cover hoặc file ảnh cover bị lỗi.");
}

/* 3. LƯU BÀI VIẾT VÀO DATABASE */
$title = $_POST['title'] ?? '';
$excerpt = $_POST['excerpt'] ?? '';
$content = $_POST['content'] ?? ''; // Lúc này content đã chứa thẻ <img src="public/uploads/content/..."> gọn nhẹ
$category = $_POST['category'] ?? '';

$db->execute(
    "INSERT INTO news(title, excerpt, content, category, cover_image, author_id)
     VALUES (?, ?, ?, ?, ?, ?)",
    "sssssi",
    [
        $title,
        $excerpt,
        $content,
        $category,
        $cover,
        (int) $author_id
    ]
);

// Chuyển hướng về trang danh sách tin tức sau khi hoàn tất
header("Location: ../news.php");
exit;