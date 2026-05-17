<?php
session_start();

require_once "../Database/Database.php";

$db = new Database();

/* =========================
   CHECK LOGIN
========================= */
if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
    exit;
}
$userId = $_SESSION["id"];

/* =========================
   GET USER CURRENT DATA
========================= */
$stmt = $db->conn->prepare("
    SELECT * FROM users
    WHERE id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Không tìm thấy người dùng");
}

/* =========================
   GET FORM DATA
========================= */
$fullname = $_POST["fullname"] ?? "";
$email = $_POST["email"] ?? "";
$phone = $_POST["phone"] ?? "";
$address = $_POST["address"] ?? "";
$bio = $_POST["bio"] ?? "";
$interests = $_POST["interests"] ?? "";

/* =========================
   CREATE FOLDERS
========================= */
$avatarFolder = __DIR__ . "/../public/img/avatar/";
$coverFolder = __DIR__ . "/../public/img/cover/";

if (!file_exists($avatarFolder)) {
    mkdir($avatarFolder, 0777, true);
}

if (!file_exists($coverFolder)) {
    mkdir($coverFolder, 0777, true);
}

// Mảng định dạng ảnh hợp lệ được phép tải lên
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

/* =========================
   PROCESS AVATAR UPLOAD
========================= */
$avatarPath = $user["avatar"];

if (
    isset($_FILES["avatar"]) &&
    $_FILES["avatar"]["error"] === UPLOAD_ERR_OK &&
    !empty($_FILES["avatar"]["name"])
) {
    $avatarExt = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));

    // Kiểm tra định dạng ảnh
    if (in_array($avatarExt, $allowedExtensions)) {
        // Đổi tên file thành chuỗi ngẫu nhiên + thời gian để tránh trùng và lỗi ký tự tiếng Việt
        $avatarName = time() . "_" . md5(uniqid()) . "." . $avatarExt;
        $avatarTmp = $_FILES["avatar"]["tmp_name"];

        $avatarUploadPath = $avatarFolder . $avatarName;
        $newAvatarPath = "public/img/avatar/" . $avatarName;

        if (move_uploaded_file($avatarTmp, $avatarUploadPath)) {
            // XÓA ẢNH CŨ TRÊN Ổ CỨNG (Nếu có ảnh cũ và ảnh đó không phải ảnh mặc định hệ thống)
            if (!empty($user["avatar"]) && file_exists(__DIR__ . "/../" . $user["avatar"])) {
                // Đảm bảo không xóa nhầm file avatar.jpg mặc định gốc nếu cậu để chung thư mục
                if (basename($user["avatar"]) !== 'avatar.jpg') {
                    unlink(__DIR__ . "/../" . $user["avatar"]);
                }
            }
            $avatarPath = $newAvatarPath;
        }
    }
}

/* =========================
   PROCESS COVER UPLOAD
========================= */
$coverPath = $user["cover"];

if (
    isset($_FILES["cover"]) &&
    $_FILES["cover"]["error"] === UPLOAD_ERR_OK &&
    !empty($_FILES["cover"]["name"])
) {
    $coverExt = strtolower(pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION));

    // Kiểm tra định dạng ảnh
    if (in_array($coverExt, $allowedExtensions)) {
        // Đổi tên file an toàn
        $coverName = time() . "_" . md5(uniqid()) . "." . $coverExt;
        $coverTmp = $_FILES["cover"]["tmp_name"];

        $coverUploadPath = $coverFolder . $coverName;
        $newCoverPath = "public/img/cover/" . $coverName;

        if (move_uploaded_file($coverTmp, $coverUploadPath)) {
            // XÓA ẢNH BÌA CŨ TRÊN Ổ CỨNG
            if (!empty($user["cover"]) && file_exists(__DIR__ . "/../" . $user["cover"])) {
                unlink(__DIR__ . "/../" . $user["cover"]);
            }
            $coverPath = $newCoverPath;
        }
    }
}

/* =========================
   UPDATE DATABASE
========================= */
$updateStmt = $db->conn->prepare("
    UPDATE users
    SET
        fullname = ?,
        email = ?,
        phone = ?,
        address = ?,
        bio = ?,
        interests = ?,
        avatar = ?,
        cover = ?
    WHERE id = ?
");

$updateStmt->bind_param(
    "ssssssssi",
    $fullname,
    $email,
    $phone,
    $address,
    $bio,
    $interests,
    $avatarPath,
    $coverPath,
    $userId
);

$updateStmt->execute();

/* =========================
   REDIRECT TO PROFILE PAGE
========================= */
header("Location: ../profile.php");
exit;
?>