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
   GET USER
========================= */

$stmt = $db->conn->prepare("
    SELECT * FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $userId);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

/* =========================
   USER NOT FOUND
========================= */

if (!$user) {

    die("Không tìm thấy người dùng");
}

$userId = $user["id"];

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

$avatarFolder = __DIR__ . "/../public/uploads/avatar/";
$coverFolder = __DIR__ . "/../public/uploads/cover/";

if (!file_exists($avatarFolder)) {

    mkdir($avatarFolder, 0777, true);
}

if (!file_exists($coverFolder)) {

    mkdir($coverFolder, 0777, true);
}

/* =========================
   AVATAR
========================= */

$avatarPath = $user["avatar"];

if (
    isset($_FILES["avatar"]) &&
    !empty($_FILES["avatar"]["name"])
) {

    $avatarName = time() . "_" . basename($_FILES["avatar"]["name"]);

    $avatarTmp = $_FILES["avatar"]["tmp_name"];

    // Path thật để upload
    $avatarUploadPath = $avatarFolder . $avatarName;

    // Path lưu DB
    $avatarPath = "public/uploads/avatar/" . $avatarName;

    move_uploaded_file($avatarTmp, $avatarUploadPath);
}

/* =========================
   COVER
========================= */

$coverPath = $user["cover"];

if (
    isset($_FILES["cover"]) &&
    !empty($_FILES["cover"]["name"])
) {

    $coverName = time() . "_" . basename($_FILES["cover"]["name"]);

    $coverTmp = $_FILES["cover"]["tmp_name"];

    // Path thật để upload
    $coverUploadPath = $coverFolder . $coverName;

    // Path lưu DB
    $coverPath = "public/uploads/cover/" . $coverName;

    move_uploaded_file($coverTmp, $coverUploadPath);
}

/* =========================
   UPDATE USER
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
   REDIRECT
========================= */

header("Location: ../profile.php");
exit;
?>