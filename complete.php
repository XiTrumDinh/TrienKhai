<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hoàn tất</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/process_order.css">
    <link rel="stylesheet" href="public/css/style.css">


</head>

<body>

    <?php include "navbar.php"; ?>
    <div class="complete-container">
        <div class="complete-box">

            <!-- STEPS -->
            <div class="cart-steps">
                <div class="step">
                    <div class="icon">🛒</div>
                    <div>Giỏ hàng</div>
                </div>
                <div class="step">
                    <div class="icon">👤</div>
                    <div>Thông tin</div>
                </div>
                <div class="step">
                    <div class="icon">💳</div>
                    <div>Thanh toán</div>
                </div>
                <div class="step active">
                    <div class="icon">✔️</div>
                    <div>Hoàn tất</div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="complete-content">
                <div class="complete-icon">✅</div>
                <div class="complete-title">Đặt hàng thành công!</div>
                <div class="complete-desc">
                    Đơn hàng của bạn đã được ghi nhận.
                </div>

                <div class="countdown">
                    Tự động chuyển trang sau <span id="time">10</span>s
                </div>

                <a href="shipping.php" class="complete-btn">
                    Theo dõi đơn hàng
                </a>
            </div>

        </div>
    </div>

    <?php include "footer.php"; ?>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/process_order.js"></script>
   
    <script src="public/js/footer.js"></script>
  

</body>

</html>