<?php
session_start();
include_once "Database/Database.php";

$db = new Database();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
// REMOVE VOUCHER 
if (isset($_POST['remove_voucher'])) {
    unset($_SESSION['voucher']);
    unset($_SESSION['discount']);
}

// TÍNH GIỎ HÀNG 
$total = 0;
$totalQty = 0;
$cart_items = [];

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

    $conn = $db->conn;

    foreach ($_SESSION['cart'] as $id => $qty) {

        $id = (int)$id;
        $qty = (int)$qty;

        $sql = "SELECT * FROM products WHERE id = $id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {

            $row = $result->fetch_assoc();
            $price = (float)$row['price'];

            $subtotal = $price * $qty;

            $total += $subtotal;
            $totalQty += $qty;

            $row['qty'] = $qty;
            $cart_items[] = $row;
        }
    }
}

// APPLY VOUCHER
$discount = 0;

if (isset($_POST['apply_voucher'])) {

    $code = strtoupper(trim($_POST['voucher']));

    $sql = "SELECT * FROM voucher WHERE voucher = ?";
    $coupon = $db->select($sql, "s", [$code]);

    if (empty($coupon)) {

        $voucher_msg = "Mã giảm giá không hợp lệ!";
        unset($_SESSION['voucher']);
        unset($_SESSION['discount']);
    } else {

        $coupon = $coupon[0];

        if ($coupon['discount_type'] == 'percent') {
            $discount = $total * ($coupon['discount_value'] / 100);
        } else {
            $discount = $coupon['discount_value'];
        }

        if ($discount > $total) {
            $discount = $total;
        }

        $_SESSION['voucher'] = $coupon;
        $_SESSION['discount'] = $discount;
    }
}

// GIỮ VOUCHER SAU REFRESH 
if (isset($_SESSION['voucher'])) {

    $coupon = $_SESSION['voucher'];

    if ($coupon['discount_type'] == 'percent') {
        $discount = $total * ($coupon['discount_value'] / 100);
    } else {
        $discount = $coupon['discount_value'];
    }

    if ($discount > $total) {
        $discount = $total;
    }

    $_SESSION['discount'] = $discount;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/cart.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="cart-container">
        <a href="index.php" class="back-home">← Trở về trang chủ</a>

        <div class="cart-box">

            <!-- STEPS -->
            <div class="cart-steps">
                <div class="step active">
                    <div class="icon">🛒</div>
                    <div class="label">Giỏ hàng</div>
                </div>
                <div class="step">
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

            <!-- CART ITEMS -->
            <?php foreach ($cart_items as $row) { ?>
                <div class="cart-item">
                    <img src="public/img/<?php echo $row['image']; ?>" />

                    <div class="item-info">
                        <h4><?php echo $row['name']; ?></h4>
                    </div>

                    <div class="item-actions">
                        <p class="price"><?php echo number_format($row['price']); ?>₫</p>
                        <p class="price_old"><?php echo number_format($row['old_price']); ?>₫</p>

                        <div class="quantity d-flex align-items-center gap-2">
                            <a href="Controller/updatecart.php?id=<?php echo $row['id']; ?>&action=minus"
                                class="btn btn-sm btn-outline-secondary">-</a>

                            <input type="number" value="<?php echo $row['qty']; ?>"
                                readonly style="width:60px; text-align:center;">

                            <a href="Controller/updatecart.php?id=<?php echo $row['id']; ?>&action=plus"
                                class="btn btn-sm btn-outline-secondary">+</a>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- VOUCHER -->
            <div class="discount-box">

                <?php if (!isset($_SESSION['voucher'])) { ?>

                    <form method="POST">
                        <label>Mã giảm giá</label>
                        <div class="discount-input">
                            <input type="text" name="voucher" placeholder="Nhập mã giảm giá" required>
                            <button type="submit" name="apply_voucher">Áp dụng</button>
                        </div>
                    </form>

                <?php } else { ?>

                    <div class="voucher-applied">
                        <p style="color:green;">
                            ✅ Đã áp dụng: <b><?php echo $_SESSION['voucher']['voucher']; ?></b>
                        </p>

                        <form method="POST">
                            <button name="remove_voucher" class="btn btn-sm btn-danger">
                                Đổi mã khác
                            </button>
                        </form>
                    </div>

                <?php } ?>

                <?php
                if (isset($voucher_msg)) {
                    echo "<p style='color:red;'>$voucher_msg</p>";
                }
                ?>

            </div>

            <!-- SUMMARY -->
            <div class="summary-box">

                <div class="summary-row">
                    <span>Tổng sản phẩm</span>
                    <span><?php echo $totalQty; ?></span>
                </div>

                <div class="summary-row">
                    <span>Tổng tiền</span>
                    <span><?php echo number_format($total); ?>₫</span>
                </div>

                <?php if (isset($_SESSION['discount'])) { ?>
                    <div class="summary-row" style="color:green;">
                        <span>Giảm giá</span>
                        <span>- <?php echo number_format($_SESSION['discount']); ?>₫</span>
                    </div>
                <?php } ?>

                <div class="summary-row total-final">
                    <span><b>Thanh toán</b></span>
                    <span style="color:red;">
                        <b>
                            <?php
                            $final = $total - ($_SESSION['discount'] ?? 0);
                            echo number_format($final);
                            ?>₫
                        </b>
                    </span>
                </div>

            </div>

            <?php if ($totalQty > 0): ?>
                <a href="info.php">
                    <button class="order-btn">Đặt hàng</button>
                </a>
            <?php else: ?>
                <button class="order-btn" disabled style="background: gray; cursor: not-allowed;">
                    Không thể đặt hàng (giỏ trống)
                </button>
            <?php endif; ?>

        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>

</body>

</html>
```