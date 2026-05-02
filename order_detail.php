<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require_once "Database/Database.php";
$db = new Database();

// ===== GET ID =====
if (!isset($_GET['id'])) {
    die("Thiếu ID đơn hàng");
}

$order_id = $_GET['id'];
$user_id = $_SESSION['id'];
$role = $_SESSION['role'] ?? 'user';

// ===== LẤY THÔNG TIN ORDER =====
if ($role === "admin") {
    // Admin xem tất cả
    $order = $db->select(
        "SELECT * FROM orders WHERE id = ?",
        "i",
        [$order_id]
    );
} else {
    // User chỉ xem đơn của mình
    $order = $db->select(
        "SELECT * FROM orders WHERE id = ? AND user_id = ?",
        "ii",
        [$order_id, $user_id]
    );
}

if (empty($order)) {
    die("Không có quyền xem đơn này hoặc đơn không tồn tại");
}

$order = $order[0];

// ===== LẤY CHI TIẾT SẢN PHẨM =====
$sql = "SELECT oi.*, p.name, p.image, w.serial_number
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        LEFT JOIN warranties w ON w.order_item_id = oi.id
        WHERE oi.order_id = ?";

$items = $db->select($sql, "i", [$order_id]);

// ===== UPDATE ĐƠN =====
if (isset($_POST['update_order'])) {
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];

    if ($role === "admin") {
        $sql = "UPDATE orders SET phone = ?, address = ?, note = ? WHERE id = ?";
        $db->execute($sql, "sssi", [$phone, $address, $note, $order_id]);
    } else {
        $sql = "UPDATE orders SET phone = ?, address = ?, note = ? WHERE id = ? AND user_id = ?";
        $db->execute($sql, "sssii", [$phone, $address, $note, $order_id, $user_id]);
    }

    header("Location: order_detail.php?id=" . $order_id);
    exit();
}

// ===== HỦY ĐƠN =====
if (isset($_POST['cancel_order'])) {

    if ($role === "admin") {
        $sql = "DELETE FROM orders WHERE id = ?";
        $db->execute($sql, "i", [$order_id]);
    } else {
        $sql = "DELETE FROM orders WHERE id = ? AND user_id = ?";
        $db->execute($sql, "ii", [$order_id, $user_id]);
    }

    header("Location: shipping.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/order_detail.css">

</head>

<body>

    <?php include "navbar.php"; ?>
    <div class="order-container">
        <div class="order-box">

            <a href="shipping.php" class="back-btn">← Quay lại</a>

            <div class="order-title">
                Đơn hàng #<?= $order['id'] ?>
            </div>

            <!-- CUSTOMER -->
            <div class="customer-box">
                <p><b>Tên:</b> <?= $order['name'] ?></p>
                <p><b>SĐT:</b> <?= $order['phone'] ?></p>
                <?php if (!empty($order['email'])): ?>
                    <p><b>Email:</b> <?= $order['email'] ?></p>
                <?php endif; ?>
                <p><b>Địa chỉ:</b> <?= $order['address'] ?></p>
                <?php if (!empty($order['note'])): ?>
                    <p><b>Note:</b> <?= $order['note'] ?></p>
                <?php endif; ?>
            </div>

            <!-- STATUS -->
            <div class="order-status">
                Trạng thái:
                <span class="badge bg-warning"><?= $order['status'] ?></span>
            </div>

            <!-- PRODUCTS -->
            <div class="product-list">
                <?php foreach ($items as $i): ?>
                    <div class="product-item">

                        <img src="public/img/<?= $i['image'] ?>" class="product-img">

                        <div class="product-info">
                            <h5><?= $i['name'] ?></h5>
                            <span>Số lượng: x<?= $i['quantity'] ?></span>
                            <p class="text-muted" style="font-size: 13px;">
                                Serial: <b><?= $i['serial_number'] ?? 'Chưa có' ?></b>
                            </p>
                        </div>

                        <div class="product-price">
                            <span class="price"><?= number_format($i['price']) ?>₫</span>
                            <span><?= number_format($i['price'] * $i['quantity']) ?>₫</span>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <!-- TOTAL -->
            <div class="total-box">
                <div class="total-row">
                    <span>Tổng tiền</span>
                    <span><?= number_format($order['total']) ?>₫</span>
                </div>

                <div class="total-row">
                    <span>Giảm giá</span>
                    <span><?= number_format($order['discount']) ?>₫</span>
                </div>

                <div class="total-final">
                    <span> Thanh toán</span>
                    <span><?= number_format($order['final_total']) ?>₫</span>

                </div>
            </div>
            <div class="order-actions mt-3 d-flex justify-content-end gap-2">

                <!-- Luôn có nút liên hệ -->
                <button
                    class="btn btn-warning"
                    onclick="window.location.href='chat.php?order=<?= $order['id'] ?>'">
                    Liên Hệ
                </button>

                <?php if ($order['status'] == 'pending'): ?>

                    <!-- SỬA -->
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editOrder">
                        Sửa thông tin
                    </button>

                    <!-- HỦY -->
                    <form method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đơn?');">
                        <button name="cancel_order" class="btn btn-danger">
                            Hủy đơn
                        </button>
                    </form>

                <?php endif; ?>
                <?php if ($order['status'] == 'completed'): ?>
                    <button class="btn btn-success"
                        onclick="event.stopPropagation(); window.location.href='comment.php?id=<?= $order['id'] ?>'">
                        Đánh giá
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editOrder">
        <div class="modal-dialog">
            <form method="POST">
                <div class="modal-content p-3">

                    <h5>Sửa thông tin</h5>

                    <label>SĐT</label>
                    <input type="text" name="phone" class="form-control mb-2" value="<?= $order['phone'] ?>">

                    <label>Địa chỉ</label>
                    <input type="text" name="address" class="form-control mb-3" value="<?= $order['address'] ?>">

                    <label>Ghi chú</label>
                    <input type="text" name="note" class="form-control mb-3" value="<?= $order['note'] ?>">

                    <button name="update_order" class="btn btn-primary">
                        Lưu
                    </button>

                </div>
            </form>
        </div>
    </div>

    <?php include "footer.php" ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
</body>

</html>