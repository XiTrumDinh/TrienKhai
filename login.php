<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

require_once "Database/Database.php";

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $user = $db->select($sql, "ss", [$username, $password]);

    if (!empty($user)) {
        $_SESSION["user"] = $user[0]["username"];
        $_SESSION["role"] = $user[0]["role"];   // thêm dòng này

        header("Location: index.php");
        exit();
    } else {
        $_SESSION["error"] = "Sai tài khoản hoặc mật khẩu!";
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Kipeeda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/login.css">

</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="login-wrapper">
        <div class="login-card">

            <h3 class="text-center mb-4">Đăng nhập</h3>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST">

                <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

                <div class="d-flex justify-content-between mb-3">
                    <a href="#">Quên mật khẩu?</a>
                    <a href="register.php">Đăng ký</a>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="check" id="check" class="form-check-input">
                    <label for="check" class="form-check-label">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                <button class="btn w-100 login-btn">
                    Login
                </button>

            </form>

        </div>
    </div>

    <?php include "footer.php" ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
</body>

</html>