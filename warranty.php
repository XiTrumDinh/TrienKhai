<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/warranty.css">

</head>

<body>

    <?php include_once "navbar.php"; ?>

    <div class="lookup-page">

        <div class="lookup-card">

            <h3 class="lookup-title">Tra cứu bảo hành</h3>
            <p class="lookup-sub">
                Nhập mã đơn hàng hoặc số serial để kiểm tra tình trạng bảo hành
            </p>


            <!-- FORM -->
            <form method="POST" class="lookup-form">
                <div class="lookup-input-group">
                    <input type="text" name="code" class="lookup-input" placeholder="VD: DH123456 hoặc SN987654..."
                        required>

                    <button type="submit" class="lookup-btn">
                        Tra cứu
                    </button>
                </div>
            </form>

            <!-- RESULT -->
            <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
                <div class="lookup-result">

                    <div class="lookup-result-header">
                        <span class="lookup-badge active">Còn bảo hành</span>
                    </div>

                    <div class="lookup-grid">
                        <div class="lookup-item">
                            <span>Sản phẩm</span>
                            <strong>ASUS Vivobook</strong>
                        </div>

                        <div class="lookup-item">
                            <span>Mã đơn</span>
                            <strong>DH123456</strong>
                        </div>

                        <div class="lookup-item">
                            <span>Ngày mua</span>
                            <strong>01/01/2026</strong>
                        </div>

                        <div class="lookup-item">
                            <span>Hết hạn</span>
                            <strong>01/01/2028</strong>
                        </div>
                    </div>

                </div>
            <?php endif; ?>

        </div>

    </div>
<br>
<br>
    <div class="container">

        <div class="lookup-info-wrapper">

            <div class="lookup-info-card">
                <h5>📘 Hướng dẫn tra cứu</h5>

             
                <p class="lookup-desc">
                    Thực hiện theo các bước sau để kiểm tra bảo hành nhanh chóng
                </p>

                <ul>
                    <li>Nhập mã đơn hàng hoặc số serial của sản phẩm</li>
                    <li>Kiểm tra lại thông tin trước khi gửi</li>
                    <li>Kết quả sẽ hiển thị ngay bên dưới</li>
                </ul>
            </div>
            <div class="lookup-info-card">
                <h5>⚠️ Lưu ý</h5>

                <p class="lookup-desc">
                    Một số điều quan trọng bạn cần biết khi tra cứu bảo hành
                </p>

                <ul>
                    <li>Chỉ áp dụng cho sản phẩm mua tại KIPEEDA</li>
                    <li>Không áp dụng cho sản phẩm bị hư hỏng do tác động bên ngoài</li>
                    <li>Giữ lại hóa đơn để được hỗ trợ nhanh hơn</li>
                </ul>
            </div>

        </div>

    </div>
    <div class="lookup-help">
        <p>Bạn cần hỗ trợ nhanh?</p>
        <p>Liên hệ với chúng tôi ngay!</p>
        <a href="contact.php" class="lookup-help-btn">Chat với chúng tôi</a>
    </div>

    <?php include "footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
</body>

</html>