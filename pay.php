<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/pay.css">
</head>

<body>
    <?php include_once "navbar.php"; ?>
    <div class="container">

        <!-- Address -->
        <h5 class="address">
            Địa Chỉ:Linh Xuân,Thủ Đức
        </h5>

        <div class="info">
            <h5>Sản phẩm:Laptop HP Pavilion 15</h5>

            <div class="row">
                <h5>Lời nhắn:</h5>
                <input type="text" placeholder="Nhập lời nhắn...">
            </div>

            <div class="row">
                <h5>Voucher:</h5>
                <input type="text" placeholder="Nhập mã voucher...">
            </div>
        </div>

        <div class="payment">

            <h5>Phương thức vận chuyển</h5>
            <div class="option">

                <label class="option-box ship">
                    <input type="radio" name="shipping">
                    <strong>Giao hàng nhanh</strong>
                    <p>2 - 3 ngày</p>
                    <span>20.000đ</span>
                </label>

                <label class="option-box express">
                    <input type="radio" name="shipping">
                    <strong>Ship hỏa tốc</strong>
                    <p>Trong ngày</p>
                    <span>50.000đ</span>
                </label>

            </div>

            <h5>Phương thức thanh toán</h5>
            <div class="option">

                <label class="option-box cod">
                    <input type="radio" name="payment">
                    <strong>Thanh toán khi nhận hàng</strong>
                    <p>Trả tiền mặt khi shipper giao</p>
                </label>

                <label class="option-box online">
                    <input type="radio" name="payment">
                    <strong>Thanh toán online</strong>
                    <p>Ví điện tử / chuyển khoản</p>
                </label>
            </div>
        </div>
        <div class="endpay">
            <h5>Chi Tiết thanh toán:</h5>

            <div class="summary">
                <div class="summary-content">
                    <h6>Sản phẩm: Laptop HP Pavilion 15</h6>
                    <h6>Số tiền: 18.990.000đ</h6>

                    <a href="shipping.php"><button class="order-btn">Đặt hàng</button></a>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public\js\footer.js"></script>
</body>

</html>