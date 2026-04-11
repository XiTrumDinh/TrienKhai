<?php
session_start();
include_once "Database/Database.php";
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}
$db = new Database();

$total = 0;
$totalQty = 0;

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $qty) {
        $sql = "SELECT * FROM products WHERE id = $id";
        $result = $db->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total += $row['price'] * $qty;
            $totalQty += $qty;
        }
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
                <div class="step ">
                    <div class="icon">🛒</div>
                    <div class="label">Giỏ hàng</div>
                </div>
                <div class="step active">
                    <div class="icon">👤</div>
                    <div class="label">Thông tin</div>
                </div>
                <div class="step">
                    <div class="icon">💳</div>
                    <div class="label">Thanh toán</div>
                </div>
                <div class="step">
                    <div class="icon">✔️</div>
                    <div class="label">Hoàn tất</div>
                </div>
            </div>




            <div class="info-container">

                <div class="info-form">
                    <h5>Thông tin nhận hàng</h5>

                    <form id="orderForm" action="pay.php" method="POST">
                        <input type="text" name="name" class="form-control" placeholder="Họ và tên" required>
                        <input type="text" name="phone" class="form-control" placeholder="SĐT" required>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <input type="text" name="address" class="form-control" placeholder="Địa chỉ" required>
                        <textarea name="note" class="form-control" placeholder="Ghi chú"></textarea>
                    </form>
                </div>

                <div class="info-money">
                    <h5 style="margin-bottom: 16px;">Tóm tắt đơn hàng</h5>

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

            <!-- BUTTON RA NGOÀI -->
            <button form="orderForm" class="order-btn">
                Tiếp tục thanh toán
            </button>



        </div>
    </div>
    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>

</body>

</html>