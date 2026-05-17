<?php
session_start();
include_once "../Database/Database.php";

$db = new Database();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); // Sửa lại đường dẫn nếu login.php ở thư mục gốc
    exit();
}

$user_id = $_SESSION['id'];

// Kiểm tra xem có đúng là gửi từ Form POST và có order_id không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    
    $orderId = $_POST['order_id'];

    /* =========================
       DELETE WARRANTIES
    ========================= */
    $db->execute("
        DELETE warranties
        FROM warranties
        INNER JOIN order_items
        ON warranties.order_item_id = order_items.id
        WHERE order_items.order_id = ?
    ", "i", [$orderId]);

    /* =========================
       DELETE ORDER ITEMS
    ========================= */
    $db->execute("
        DELETE FROM order_items
        WHERE order_id = ?
    ", "i", [$orderId]);

    /* =========================
       DELETE ORDER
    ========================= */
    $db->execute(
        "DELETE FROM orders WHERE id = ? AND user_id = ?",
        "ii",
        [$orderId, $user_id]
    );

    // ===== QUAY TRỞ LẠI TRANG CŨ SAU KHI XÓA THÀNH CÔNG =====
    // Cách 1: Quay lại đúng trang vừa bấm nút (Khuyên dùng)
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        // Cách 2: Nếu không tìm thấy trang cũ, chỉ định một trang mặc định (ví dụ: index.php hoặc orders.php)
        header("Location: ../shipping.php"); 
    }
    exit();

} else {
    // Nếu ai đó cố tình truy cập trực tiếp file này bằng URL (GET) thì đá họ về trang chủ
    header("Location: ../shipping.php");
    exit();
}