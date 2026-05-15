<?php
session_start();
require_once "Database/Database.php";

$db = new Database();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm = trim($_POST["confirm_password"]);

    // check confirm password
    if ($password != $confirm) {

        $message = "Mật khẩu không khớp!";
    } else {

        // check username
        $checkUser = $db->select(
            "SELECT * FROM users WHERE username = ?",
            "s",
            [$username]
        );

        // check email
        $checkEmail = $db->select(
            "SELECT * FROM users WHERE email = ?",
            "s",
            [$email]
        );

        if ($checkUser) {

            $message = "Username đã tồn tại!";
        } elseif ($checkEmail) {

            $message = "Email đã tồn tại!";
        } else {

            // mã hóa password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // INSERT
            $db->execute(
                "INSERT INTO users(username,password,email,role)
                 VALUES(?,?,?,?)",
                "ssss",
                [$username, $passwordHash, $email, "user"]
            );

            $_SESSION["success"] = "Đăng ký thành công!";

            header("Location: index.php");
            exit;
        }
    }
}
?>
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

            <form method="POST">

                <input type="text"
                    name="username"
                    class="form-control mb-3"
                    placeholder="Username"
                    required>

                <!-- EMAIL + BUTTON -->
                <div class="d-flex gap-2 mb-3">
                    <input type="email"
                        name="email"
                        class="form-control"
                        id="email"
                        placeholder="Email"
                        required>
                   
                </div>

                

                <input type="password"
                    name="password"
                    class="form-control mb-3"
                    placeholder="Password"
                    required>
                <input type="password"
                    name="confirm_password"
                    class="form-control mb-3"
                    placeholder="Nhập lại Password"
                    required>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="agree" required>
                    <label for="agree" class="form-check-label">
                        Đồng ý với điều khoản và chính sách bảo mật
                    </label>
                </div>
                <button class="btn w-100 login-btn">
                    Đăng ký
                </button>
                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
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



</body>

</html>