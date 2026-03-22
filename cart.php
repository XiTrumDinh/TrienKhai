<?php
session_start();
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

            <!-- Item -->
            <div class="cart-item">
                <img src="public/img/pc1.jpg" alt="product" />
                <div class="item-info">
                    <h4>PC GVN Intel i5-14400F/VGA ARC B580</h4>
                </div>
                <div class="item-actions">
                    <p class="price-old">23.620.000₫</p>
                    <p class="price">22.190.000₫</p>
                    <div class="quantity">
                        <button class="minus">-</button>
                        <input type="number" value="1" min="1" />
                        <button class="plus">+</button>
                    </div>
                </div>
            </div>


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
                    <span class="label">Tổng tiền</span>
                    <span class="value">240.000đ</span>
                </div>
            </div>

            <button class="order-btn">Đặt hàng</button>
        </div>
    </div>
    <?php include "footer.php" ?>


    <script src="public/js/cart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>

</body>

</html>