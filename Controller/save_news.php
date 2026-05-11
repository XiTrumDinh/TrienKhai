<?php
session_start();
require_once "../Database/Database.php";

$db = new Database();

$uploadDir = "../public/uploads/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* upload ảnh cover */
$filename = time() . "_" . basename($_FILES['cover_file']['name']);

move_uploaded_file(
    $_FILES['cover_file']['tmp_name'],
    $uploadDir . $filename
);

$cover = "public/uploads/" . $filename;

/* lấy id user đang đăng nhập */
$author_id = $_SESSION['id'] ?? null;

if (!$author_id) {
    die("Bạn chưa đăng nhập");
}

/* lưu bài viết */
$db->execute(
    "INSERT INTO news(title, excerpt, content, category, cover_image, author_id)
     VALUES (?, ?, ?, ?, ?, ?)",
    "sssssi",
    [
        $_POST['title'],
        $_POST['excerpt'],
        $_POST['content'],
        $_POST['category'],
        $cover,
        $author_id
    ]
);

header("Location: ../news.php");
exit;
