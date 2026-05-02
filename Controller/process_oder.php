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
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$note = $_POST['note'] ?? '';
$payment = $_POST['payment'] ?? 'cod';

// ===== VALIDATE NHẸ =====
if (!$name || !$phone || !$address) {
    echo "<script>alert('Thiếu thông tin!'); history.back();</script>";
    exit();
}

// ===== TÍNH TIỀN =====
$total = 0;

foreach ($_SESSION['cart'] as $id => $qty) {

    $id = (int) $id;
    $qty = (int) $qty;

    $result = $db->conn->query("SELECT p.price, c.warranty_months 
FROM products p
JOIN categories c ON p.category_id = c.id
WHERE p.id = $id");

    if ($row = $result->fetch_assoc()) {
        $total += $row['price'] * $qty;
    }
}

$discount = $_SESSION['discount'] ?? 0;
$final = $total - $discount;
$voucher_code = $_SESSION['voucher']['voucher'] ?? null;
// ===== INSERT ORDER =====
$stmt = $db->conn->prepare("
    INSERT INTO orders 
    (user_id, name, phone, email, address, note, total, discount, final_total, status, voucher_code)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,'pending', ?)
");

$user_id = $_SESSION['id'];

$stmt->bind_param(
    "isssssddds",
    $user_id,
    $name,
    $phone,
    $email,
    $address,
    $note,
    $total,
    $discount,
    $final,
    $voucher_code
);

$stmt->execute();
$order_id = $stmt->insert_id;

// ===== INSERT ORDER ITEMS =====
foreach ($_SESSION['cart'] as $id => $qty) {

    $id = (int) $id;
    $qty = (int) $qty;

    $result = $db->conn->query("SELECT price FROM products WHERE id=$id");

    if ($row = $result->fetch_assoc()) {

        // 🔥 Lặp theo số lượng
        for ($i = 0; $i < $qty; $i++) {

            // 👉 1 sản phẩm = 1 dòng
            $stmt_item = $db->conn->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (?, ?, 1, ?)
            ");

            $stmt_item->bind_param(
                "iid",
                $order_id,
                $id,
                $row['price']
            );

            $stmt_item->execute();

            // 👉 lấy id vừa tạo
            $order_item_id = $stmt_item->insert_id;

            // ====================
            // 👉 TẠO BẢO HÀNH
            // ====================
            $serial = "SN" . strtoupper(uniqid());

            $start = date("Y-m-d");
            $months = $row['warranty_months'] ?? 12;

            $end = date("Y-m-d", strtotime("+$months months"));

            $stmt_w = $db->conn->prepare("
                INSERT INTO warranties (order_item_id, serial_number, warranty_start, warranty_end)
                VALUES (?, ?, ?, ?)
            ");

            $stmt_w->bind_param(
                "isss",
                $order_item_id,
                $serial,
                $start,
                $end
            );

            $stmt_w->execute();
        }
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
