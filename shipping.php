<?php
session_start();
include_once "Database/Database.php";

$db = new Database();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// ===== LẤY TẤT CẢ ĐƠN =====
$sql = "
    SELECT * FROM orders 
    WHERE user_id = ? AND status = 'pending'
    ORDER BY id DESC
";

$orders = $db->select($sql, "i", [$user_id]);

// ===== LẤY ITEMS CHO TỪNG ORDER =====
$order_items_map = [];

if (!empty($orders)) {
    foreach ($orders as $o) {

        $sql_items = "
            SELECT 
                oi.*, 
                p.name, 
                p.image, 
                c.name AS category_name
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE oi.order_id = ?
        ";

        $items = $db->select($sql_items, "i", [$o['id']]);
        $order_items_map[$o['id']] = $items;
    }
}

// ===== HỦY ĐƠN =====
if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];

    $sql_delete = "DELETE FROM orders WHERE id = ? AND user_id = ?";
    $db->execute($sql_delete, "ii", [$order_id, $user_id]);

    header("Location: shipping.php");
    exit();
}

// ===== UPDATE =====
if (isset($_POST['update_order'])) {
    $id = $_POST['order_id'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE orders SET phone = ?, address = ? WHERE id = ? AND user_id = ?";
    $db->execute($sql, "ssii", [$phone, $address, $id, $user_id]);

    header("Location: shipping.php");
    exit();
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
                <div class="step active" onclick="goToPage('shipping.php')">
                    <div class="icon">📋</div>
                    <div class="label">Chờ xác nhận</div>
                </div>

                <div class="step" onclick="goToPage('packing.php')">
                    <div class="icon">📦</div>
                    <div class="label">Đóng gói</div>
                </div>

                <div class="step" onclick="goToPage('come.php')">
                    <div class="icon">🚚</div>
                    <div class="label">Đang giao</div>
                </div>

                <div class="step" onclick="goToPage('completed.php')">
                    <div class="icon">⭐</div>
                    <div class="label">Đánh giá</div>
                </div>
            </div>

            <!-- ORDER CARD -->
            <?php if (!empty($orders)) { ?>

                <?php foreach ($orders as $order) { ?>

                    <?php
                    $items = $order_items_map[$order['id']] ?? [];
                    $firstItem = $items[0] ?? null;
                    $itemCount = count($items);

                    $totalQty = 0;
                    foreach ($items as $i) {
                        $totalQty += $i['quantity'];
                    }
                    ?>

                    <div class="order-card" onclick="goDetail(<?= $order['id'] ?>)">

                        <!-- HEADER -->
                        <div class="order-header">
                            <div class="shop-name">🏬 KiPeeDa</div>
                            <div class="order-status"><?php echo $order['status']; ?></div>
                        </div>

                        <!-- FIRST ITEM -->
                        <?php if ($firstItem) { ?>
                            <div class="order-item">

                                <img src="public/img/<?php echo $firstItem['image']; ?>" class="product-img">

                                <div class="product-info">
                                    <h4><?php echo $firstItem['name']; ?></h4>
                                    <p class="variant">Phân loại: <?= $firstItem['category_name'] ?></p>
                                    <span class="qty">x<?php echo $firstItem['quantity']; ?></span>
                                </div>

                                <div class="price-box">
                                    <?php echo number_format($firstItem['price']); ?>₫
                                </div>

                            </div>
                        <?php } ?>

                        <!-- VIEW MORE -->
                        <?php if ($itemCount > 1) { ?>
                            <div class="text-center">
                                <button class="btn-view-more" onclick="toggleItems(<?php echo $order['id']; ?>)">
                                    Xem thêm (<?php echo $itemCount - 1; ?> sản phẩm)
                                </button>
                            </div>

                            <div id="more-<?php echo $order['id']; ?>" style="display:none;">

                                <?php foreach ($items as $index => $item) {
                                    if ($index == 0)
                                        continue;
                                ?>

                                    <div class="order-item small">

                                        <img src="public/img/<?php echo $item['image']; ?>" class="product-img">

                                        <div class="product-info">
                                            <h5><?php echo $item['name']; ?></h5>
                                            <span>x<?php echo $item['quantity']; ?></span>
                                        </div>

                                        <div class="price-box">
                                            <?php echo number_format($item['price']); ?>₫
                                        </div>

                                    </div>

                                <?php } ?>

                            </div>
                        <?php } ?>

                        <!-- FOOTER -->
                        <div class="order-footer">

                            <div>
                                <div>Giảm giá: <?php echo number_format($order['discount']); ?>₫</div>
                                <div>
                                    Tổng tiền (<?php echo $totalQty; ?> SP):
                                    <b style="color:red;">
                                        <?php echo number_format($order['final_total']); ?>₫
                                    </b>
                                </div>
                            </div>

                            <div class="d-flex gap-2">

                                <button
                                    class="btn btn-warning"
                                    onclick="event.stopPropagation(); window.location.href='text.php?order=<?= $order['id'] ?>'">
                                    Liên Hệ
                                </button>

                                <form method="POST" onclick="event.stopPropagation();" onsubmit="return confirm('Hủy đơn?');">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit" name="cancel_order" class="btn btn-danger"
                                        onclick="event.stopPropagation();">
                                        Hủy
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>
                <p style="text-align:center">Không có đơn hàng</p>
            <?php } ?>






        </div>
    </div>


    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
    <script src="public/js/shipping.js"></script>
    <script>
        function goDetail(id) {
            window.location.href = "order_detail.php?id=" + id;
        }
    </script>

</body>

</html>
```