<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// chỉ admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}

require_once "Database/Database.php";
$db = new Database();

// ===== GET ID =====
if (!isset($_GET['id'])) {
    die("Thiếu ID đơn hàng");
}

$order_id = $_GET['id'];

// ===== LẤY THÔNG TIN ORDER =====
$order = $db->select(
    "SELECT * FROM orders WHERE id = ?",
    "i",
    [$order_id]
);

if (empty($order)) {
    die("Không tìm thấy đơn hàng");
}

$order = $order[0];

// ===== LẤY CHI TIẾT SẢN PHẨM =====
$sql = "SELECT oi.*, p.name, p.image 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?";

$items = $db->select($sql, "i", [$order_id]);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

<h3>Chi tiết đơn hàng #<?= $order['id'] ?></h3>

<a href="order.php" class="btn btn-secondary mb-3">← Quay lại</a>

<!-- THÔNG TIN KHÁCH -->
<div class="card mb-3">
    <div class="card-body">
        <h5>Thông tin khách hàng</h5>
        <p><b>Tên:</b> <?= $order['name'] ?></p>
        <p><b>SĐT:</b> <?= $order['phone'] ?></p>
        <p><b>Email:</b> <?= $order['email'] ?></p>
        <p><b>Địa chỉ:</b> <?= $order['address'] ?></p>
        <p><b>Ghi chú:</b> <?= $order['note'] ?></p>
    </div>
</div>

<!-- TRẠNG THÁI -->
<div class="mb-3">
    <b>Trạng thái:</b>
    <?php
    switch ($order["status"]) {
        case 'pending':
            echo '<span class="badge bg-secondary">Pending</span>';
            break;
        case 'confirmed':
            echo '<span class="badge bg-warning">Confirmed</span>';
            break;
        case 'shipping':
            echo '<span class="badge bg-info">Shipping</span>';
            break;
        case 'complete':
            echo '<span class="badge bg-success">Complete</span>';
            break;
    }
    ?>
</div>

<!-- DANH SÁCH SẢN PHẨM -->
<table class="table table-bordered text-center">
    <thead class="table-light">
        <tr>
            <th>Ảnh</th>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($items as $i): ?>
        <tr>
            <td>
                <img src="public/img/<?= $i['image'] ?>" width="60">
            </td>
            <td><?= $i['name'] ?></td>
            <td><?= number_format($i['price']) ?>₫</td>
            <td><?= $i['quantity'] ?></td>
            <td><?= number_format($i['price'] * $i['quantity']) ?>₫</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- TỔNG TIỀN -->
<div class="text-end">
    <p><b>Tổng:</b> <?= number_format($order['total']) ?>₫</p>
    <p><b>Giảm giá:</b> <?= number_format($order['discount']) ?>₫</p>
    <h5><b>Thanh toán: <?= number_format($order['final_total']) ?>₫</b></h5>
</div>

</body>
</html>