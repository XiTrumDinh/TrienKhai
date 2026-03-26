<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Kipeeda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/login.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="login-wrapper">
        <div class="login-card">

            <h3 class="text-center mb-4">Đăng ký</h3>

            <form>

                <input type="text" class="form-control mb-3" placeholder="Username" required>

                <!-- EMAIL + BUTTON -->
                <div class="d-flex gap-2 mb-3">
                    <input type="email" class="form-control" id="email" placeholder="Email" required>
                    <button type="button" class="btn btn-outline-danger" onclick="sendOTP()">Gửi mã</button>
                </div>

                <!-- OTP -->
                <input type="text" class="form-control mb-3 d-none" id="otp" placeholder="Nhập mã OTP">

                <input type="password" class="form-control mb-3" placeholder="Password" required>
                <input type="password" class="form-control mb-3" placeholder="Nhập lại Password" required>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="agree" required>
                    <label for="agree" class="form-check-label">
                        Đồng ý với điều khoản và chính sách bảo mật
                    </label>
                </div>
                <button class="btn w-100 login-btn">
                    Đăng ký
                </button>

                <div class="text-center mt-3">
                    <span>Đã có tài khoản?</span>
                    <a href="login.php">Đăng nhập</a>
                </div>

            </form>

        </div>
    </div>

    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>

    <!-- Nhớ xóa cái này nha-->
    <script>
        function sendOTP() {
            const email = document.getElementById("email").value;

            if (!email) {
                alert("Nhập email trước!");
                return;
            }

            // HIỆN Ô OTP
            document.getElementById("otp").classList.remove("d-none");

            alert("Đã gửi mã OTP (giả lập 😏)");
        }
    </script>

</body>

</html>