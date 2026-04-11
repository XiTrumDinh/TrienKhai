<?php
session_start();
include_once "Database/Database.php";

$db = new Database();
$conn = $db->conn;

// ❌ chưa login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// ❌ giỏ rỗng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}


$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$note = $_POST['note'] ?? '';


$total = 0;
$totalQty = 0;

foreach ($_SESSION['cart'] as $id => $qty) {
    $id = (int)$id;
    $qty = (int)$qty;

    $result = $conn->query("SELECT * FROM products WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total += $row['price'] * $qty;
        $totalQty += $qty;
    }
}

$discount = $_SESSION['discount'] ?? 0;
$final = $total - $discount;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/info.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <?php include "navbar.php"; ?>
<div class="cart-container">
    <div class="cart-box">

        <!-- STEPS -->
        <div class="cart-steps">
            <div class="step"><div class="icon">🛒</div><div class="label">Giỏ hàng</div></div>
            <div class="step"><div class="icon">👤</div><div class="label">Thông tin</div></div>
            <div class="step active"><div class="icon">💳</div><div class="label">Thanh toán</div></div>
            <div class="step"><div class="icon">✔️</div><div class="label">Hoàn tất</div></div>
        </div>

        <div class="info-container">

            <!-- LEFT -->
            <div class="info-form">
                <h5>Thông tin thanh toán</h5>

                <form action="Controller/process_oder.php" method="POST">

                    <!-- 🔥 HIỂN THỊ LẠI THÔNG TIN -->
                    <div class="mb-3">
                        <b>Họ tên:</b> <?= htmlspecialchars($name) ?>
                    </div>

                    <div class="mb-3">
                        <b>SĐT:</b> <?= htmlspecialchars($phone) ?>
                    </div>

                    <div class="mb-3">
                        <b>Địa chỉ:</b> <?= htmlspecialchars($address) ?>
                    </div>

                    <div class="mb-3">
                        <b>Email:</b> <?= htmlspecialchars($email) ?>
                    </div>

                    <?php if (!empty($note)): ?>
                        <div class="mb-3">
                            <b>Ghi chú:</b> <?= htmlspecialchars($note) ?>
                        </div>
                    <?php endif; ?>

                    <hr>

                    <!-- 💳 CHỌN THANH TOÁN -->
                    <h6>Phương thức thanh toán</h6>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" value="cod" checked>
                        <label class="form-check-label">
                            Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" value="bank">
                        <label class="form-check-label">
                            Chuyển khoản ngân hàng
                        </label>
                    </div>

                    <!-- 🔥 GIỮ DATA -->
                    <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
                    <input type="hidden" name="phone" value="<?= htmlspecialchars($phone) ?>">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                    <input type="hidden" name="address" value="<?= htmlspecialchars($address) ?>">
                    <input type="hidden" name="note" value="<?= htmlspecialchars($note) ?>">

                    <button class="order-btn">Xác nhận thanh toán</button>
                </form>
            </div>

            <!-- RIGHT -->
            <div class="info-money">
                <h5>Tóm tắt đơn hàng</h5>
                <div class="summary-box">

                    <div class="summary-row">
                        <span>Tổng sản phẩm</span>
                        <span><?= $totalQty ?></span>
                    </div>

                    <div class="summary-row">
                        <span>Tổng tiền</span>
                        <span><?= number_format($total) ?>₫</span>
                    </div>

                    <?php if ($discount > 0): ?>
                        <div class="summary-row" style="color:green;">
                            <span>Giảm giá</span>
                            <span>-<?= number_format($discount) ?>₫</span>
                        </div>
                    <?php endif; ?>

                    <div class="summary-row total">
                        <span>Thanh toán</span>
                        <span style="color:red;">
                            <?= number_format($final) ?>₫
                        </span>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>

</body>

</html>