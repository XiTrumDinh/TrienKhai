<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/chat.css">
</head>

<body>

    <?php include "navbar.php"; ?>
    <div class="contact-container">

        <!-- SIDEBAR -->
        <div class="contact-sidebar">
            <h5>Hỗ trợ</h5>
            <ul>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">FAQ</a></li>
                <li class="active"><a href="#">Liên hệ</a></li>
            </ul>
        </div>

        <!-- CONTENT -->
        <div class="contact-content">

            <h4>Liên hệ hỗ trợ</h4>

            <div class="chat-box">

                <!-- Tin nhắn -->
                <div class="chat-messages">
                    <div class="message admin">
                        <span>Xin chào! KIPEEDA có thể giúp gì cho bạn?</span>
                    </div>

                    <div class="message user">
                        <span>Mình cần tư vấn laptop học tập</span>
                    </div>
                </div>

                <!-- Input -->
                <div class="chat-input">
                    <input type="text" placeholder="Nhập tin nhắn...">
                    <button>Gửi</button>
                </div>

            </div>

        </div>
    </div>

    <?php include "footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
</body>

</html>