<?php
session_start();

// lấy id từ URL
$id = $_GET['id'] ?? 0;
$id = (int)$id;

// nếu chưa có cart thì tạo mới
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// nếu sản phẩm đã có → tăng số lượng
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

// chuyển hướng sang giỏ hàng
header("Location: ../cart.php");
exit;