<?php
session_start();
require_once "Database\Database.php";

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $user = $db->select($sql, "ss", [$username, $password]);

    if (!empty($user)) {
        $_SESSION["user"] = $user[0]["username"];
        header("Location: index.php");
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   

</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container mt-5" style="max-width: 400px; margin-bottom: 150px;">
        <h3 class="mb-4 text-center">Đăng nhập</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input
                type="text"
                name="username"
                class="form-control mb-3"
                placeholder="Username"
                required>

            <input
                type="password"
                name="password"
                class="form-control mb-3"
                placeholder="Password"
                required>

            <p>
                Quên mật khẩu? <a href="#">Click vào đây</a>
            </p>

            <p>
                Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
            </p>

            <div class="form-check mb-3">
                <input
                    type="checkbox"
                    name="check"
                    id="check"
                    class="form-check-input">
                <label for="check" class="form-check-label">
                    Ghi nhớ đăng nhập
                </label>
            </div>

            <button class="btn btn-primary w-100">
                Login
            </button>
        </form>
    </div>
    <?php include "footer.php" ?>


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>

</body>

</html>