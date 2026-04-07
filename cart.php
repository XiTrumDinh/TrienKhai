<?php
session_start();
include_once "Database/Database.php";

$db = new Database();

// Lấy danh sách sản phẩm (ví dụ)
$sql = "SELECT * FROM products";
$result = $db->conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/cart.css">
    <link rel="stylesheet" href="public/css/style.css">

</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="cart-container">
        <a href="index.php" class="back-home">← Trở về trang chủ</a>

        <div class="cart-box">
            <!-- Banner -->
            <div class="cart-steps">
                <div class="step active">
                    <div class="icon">🛒</div>
                    <div class="label">Giỏ hàng</div>
                </div>
                <div class="step">
                    <div class="icon">👤</div>
                    <div class="label">Thông tin đặt hàng</div>
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
            <?php
            $total = 0;
            $totalQty = 0;

            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

                $conn = $db->conn; // nếu bạn đang dùng public

                foreach ($_SESSION['cart'] as $id => $qty) {

                    $id = (int)$id;
                    $qty = (int)$qty;

                    $sql = "SELECT * FROM products WHERE id = $id";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $old_price = (float)$row['old_price'];
                        $price = (float)$row['price'];
                        $subtotal = $price * $qty;

                        $total += $subtotal;
                        $totalQty += $qty;
            ?>
                        <!-- Item -->
                        <div class="cart-item">
                            <img src="public/img/<?php echo $row['image']; ?>" />

                            <div class="item-info">
                                <h4><?php echo $row['name']; ?></h4>
                            </div>

                            <div class="item-actions">
                                <p class="price"><?php echo number_format($price); ?>₫</p>
                                <p class="price_old"><?php echo number_format($old_price); ?>₫</p>

                                <div class="quantity d-flex align-items-center gap-2">

                                    <!-- nút giảm -->
                                    <a href="Controller/updatecart.php?id=<?php echo $id; ?>&action=minus"
                                        class="btn btn-sm btn-outline-secondary">-</a>

                                    <!-- số lượng -->
                                    <input type="number"
                                        value="<?php echo $qty; ?>"
                                        min="1"
                                        readonly
                                        style="width:60px; text-align:center;">

                                    <!-- nút tăng -->
                                    <a href="Controller/updatecart.php?id=<?php echo $id; ?>&action=plus"
                                        class="btn btn-sm btn-outline-secondary">+</a>

                                </div>

                            </div>
                        </div>
            <?php
                    }
                }
            }
            ?>


            <!-- Discount -->
            <div class="discount-box">
                <label>Mã giảm giá</label>
                <div class="discount-input">
                    <input type="text" placeholder="Nhập mã giảm giá" />
                    <button>Áp dụng</button>
                </div>
            </div>

            <!-- Summary -->
            <div class="summary-box">
                <div class="summary-row">
                    <span class="label">Tổng sản phẩm</span>
                    <span class="value"><?php echo $totalQty; ?></span>
                </div>

                <div class="summary-row">
                    <span class="label">Tổng tiền</span>
                    <span class="value">
                        <?php echo number_format($total, 0, ',', '.'); ?>₫
                    </span>
                </div>
            </div>

           <a href="pay.php"> <button class="order-btn">Đặt hàng</button></a>
        </div>
    </div>
    <?php include "footer.php" ?>


    <script src="public/js/cart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>

</body>

</html>