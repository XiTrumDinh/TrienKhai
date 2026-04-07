<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/shipping.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
    <?php include_once "navbar.php"; ?>
    <div class="container">
        <a href="index.php" class="back-home">← Trở về trang chủ</a>

        <div class="status-wrapper">
            <div class="cart-steps">
                <div class="step active" onclick="showStep(0)">
                    <div class="icon">⏳</div>
                    <div class="label">Chờ xác nhận</div>
                </div>

                <div class="step" onclick="showStep(1)">
                    <div class="icon">📦</div>
                    <div class="label">Chờ lấy hàng</div>
                </div>

                <div class="step" onclick="showStep(2)">
                    <div class="icon">🚚</div>
                    <div class="label">Đang vận chuyển</div>
                </div>

                <div class="step" onclick="showStep(3)">
                    <div class="icon">⭐</div>
                    <div class="label">Đánh giá</div>
                </div>
            </div>
        </div>

        <div class="step-content">
            <div class="content active">
                <div class="container bg-white">
                    <h5>Sản phẩm: Laptop HP Pavilion 15</h5>
                    <p>i5</p>
                    <p>16GB RAM</p>
                    <p>512GB SSD</p>
                    <div class="total">
                        <span>Tổng tiền:</span>
                        <strong>18.990.000đ</strong>
                    </div>

                    <div class="btn-group">
                        <button class="contact">Liên hệ Shop</button>
                        <button class="cancel">Hủy đơn</button>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container bg-white">
                    <h5>Sản phẩm: Laptop HP Pavilion 15</h5>
                    <p>i5</p>
                    <p>16GB RAM</p>
                    <p>512GB SSD</p>
                    <div class="time">
                        <h5>Thời gian nhận hàng</h5>
                        <p>Từ 12/04/2026 - 15/04/2026</p>
                    </div>
                    <div class="total">
                        <span>Tổng tiền:</span>
                        <strong>18.990.000đ</strong>
                    </div>

                    <div class="btn-group">
                        <button class="contact">Liên hệ Shop</button>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container bg-white">
                    <h5>Sản phẩm: Laptop HP Pavilion 15</h5>
                    <p>i5</p>
                    <p>16GB RAM</p>
                    <p>512GB SSD</p>
                    <div class="time">
                        <h5>Thời gian nhận hàng</h5>
                        <p>Từ 12/04/2026 - 15/04/2026</p>
                    </div>
                    <div class="total">
                        <span>Tổng tiền:</span>
                        <strong>18.990.000đ</strong>
                    </div>

                    <div class="btn-group">
                        <button class="contact">Liên hệ Shop</button>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container bg-white">
                    <h5>Sản phẩm: Laptop HP Pavilion 15</h5>
                    <p>i5</p>
                    <p>16GB RAM</p>
                    <p>512GB SSD</p>
                   <button class="comment">Bình luận/Đánh giá</button>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public\js\footer.js"></script>
    <script src="public\js\shipping.js"></script>
</body>

</html>