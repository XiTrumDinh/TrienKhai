<?php
session_start();
include_once "Database/Database.php";

$db = new Database();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$sql = "SELECT * FROM orders WHERE status = 'completed' ORDER BY id DESC";
$order = $db->select($sql);
$order = $order[0] ?? null;
$order_id = $order['id'] ?? null;

if (isset($_POST['cancel_order'])) {
    $sql_delete = "DELETE FROM orders WHERE id = ?";
    $db->execute($sql_delete, "i", [$order_id]);

    // reload lại trang
    header("Location: shipping.php");
    exit();
}
$sql_items = "
    SELECT oi.*, p.name, p.image
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
";
$cart_items = [];
$totalQty = 0;
$total = 0;

if ($order_id) {
    $sql_items = "
        SELECT oi.*, p.name, p.image
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ";

    $cart_items = $db->select($sql_items, "i", [$order_id]);

    foreach ($cart_items as $row) {
        $totalQty += $row['quantity'];
        $total += $row['price'] * $row['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/shipping.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="cart-container">
        <a href="index.php" class="back-home">← Trở về trang chủ</a>

        <div class="cart-box">

            <!-- STEPS -->
            <div class="cart-steps">
                <div class="step" onclick="goToPage('shipping.php')">
                    <div class="icon">📋</div>
                    <div class="label">Chờ xác nhận</div>
                </div>

                <div class="step" onclick="goToPage('packing.php')">
                    <div class="icon">📦</div>
                    <div class="label">Chờ đóng gói</div>
                </div>

                <div class="step" onclick="goToPage('come.php')">
                    <div class="icon">🚚</div>
                    <div class="label">Đang giao</div>
                </div>

                <div class="step  active" onclick="goToPage('completed.php')">
                    <div class="icon">⭐</div>
                    <div class="label">Đánh giá</div>
                </div>
            </div>

            <!-- CART ITEMS -->
            <?php if (!empty($cart_items)) { ?>

                <?php foreach ($cart_items as $row) { ?>
                    <div class="cart-item">
                        <img src="public/img/<?php echo $row['image']; ?>" />

                        <div class="item-info">
                            <h4><?php echo $row['name']; ?></h4>
                        </div>
                    </div>
                <?php } ?>

            <?php } else { ?>
                <p style="text-align:center; margin-top:20px;">
                    Không có sản phẩm
                </p>
            <?php } ?>

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
            </div>
            <br>
          
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
    <script src="public/js/shipping.js"></script>
</body>

</html>
```