<?php
session_start();
include_once "../Database/Database.php";

$db = new Database();

// ===== CHECK LOGIN =====
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// ===== CHECK CART =====
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Không có sản phẩm trong giỏ!'); window.location='cart.php';</script>";
    exit();
}

// ===== LẤY DATA =====
$name    = $_POST['name'] ?? '';
$phone   = $_POST['phone'] ?? '';
$email   = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$note    = $_POST['note'] ?? '';
$payment = $_POST['payment'] ?? 'cod';

// ===== VALIDATE NHẸ =====
if (!$name || !$phone || !$address) {
    echo "<script>alert('Thiếu thông tin!'); history.back();</script>";
    exit();
}

// ===== TÍNH TIỀN =====
$total = 0;

foreach ($_SESSION['cart'] as $id => $qty) {

    $id = (int)$id;
    $qty = (int)$qty;

    $result = $db->conn->query("SELECT price FROM products WHERE id=$id");

    if ($row = $result->fetch_assoc()) {
        $total += $row['price'] * $qty;
    }
}

$discount = $_SESSION['discount'] ?? 0;
$final = $total - $discount;

// ===== INSERT ORDER =====
$stmt = $db->conn->prepare("
    INSERT INTO orders 
    (user_id, name, phone, email, address, note, total, discount, final_total, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
");

$user_id = $_SESSION['user_id'] ?? NULL;

$stmt->bind_param(
    "isssssddd",
    $user_id,
    $name,
    $phone,
    $email,
    $address,
    $note,
    $total,
    $discount,
    $final
);

$stmt->execute();
$order_id = $stmt->insert_id;

// ===== INSERT ORDER ITEMS =====
foreach ($_SESSION['cart'] as $id => $qty) {

    $id = (int)$id;
    $qty = (int)$qty;

    $result = $db->conn->query("SELECT price FROM products WHERE id=$id");

    if ($row = $result->fetch_assoc()) {

        $stmt_item = $db->conn->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");

        $stmt_item->bind_param(
            "iiid",
            $order_id,
            $id,
            $qty,
            $row['price']
        );

        $stmt_item->execute();
    }
}

// ===== CLEAR CART =====
unset($_SESSION['cart']);
unset($_SESSION['discount']);
unset($_SESSION['voucher']);

// ===== LƯU ID ĐƠN (optional) =====
$_SESSION['last_order_id'] = $order_id;

// ===== REDIRECT =====
header("Location: ../complete.php");
exit();