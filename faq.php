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
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Kipeeda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/faq.css">

</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="faq-container">

        <!-- SIDEBAR -->
        <div class="faq-sidebar">
            <h5>Về KIPEEDA</h5>
            <ul>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Tuyển dụng</a></li>
            </ul>
        </div>

        <!-- CONTENT -->
        <div class="faq-content">
            <h4>Giới thiệu</h4>
            <hr>
            <div class="faq-box">
                KIPEEDA là một website chuyên cung cấp các sản phẩm công nghệ như PC, laptop và linh kiện máy tính, được
                xây dựng với mục tiêu mang đến cho người dùng trải nghiệm mua sắm đơn giản, nhanh chóng và đáng tin cậy.
                Dù bạn là học sinh, sinh viên, dân văn phòng hay game thủ, KIPEEDA đều có những lựa chọn phù hợp với nhu
                cầu của bạn.
                <br>
                Tại KIPEEDA, bạn có thể dễ dàng tìm kiếm các dòng laptop phục vụ học tập, làm việc hoặc giải trí, cũng
                như các bộ PC được build sẵn theo nhiều mức cấu hình khác nhau. Ngoài ra, website còn cung cấp đa dạng
                linh kiện như CPU, RAM, ổ cứng, card đồ họa và nhiều phụ kiện khác, giúp bạn tự do nâng cấp hoặc xây
                dựng hệ thống máy tính theo ý muốn.
                <br>
                Điểm nổi bật của KIPEEDA là giao diện thân thiện, dễ sử dụng, giúp người dùng nhanh chóng tìm thấy sản
                phẩm mình cần mà không mất quá nhiều thời gian. Mỗi sản phẩm đều được trình bày rõ ràng với thông tin
                chi tiết về cấu hình, giá cả và hình ảnh thực tế, giúp bạn có cái nhìn trực quan trước khi quyết định
                mua hàng.
                <br>
                Không chỉ dừng lại ở việc bán sản phẩm, KIPEEDA còn hướng đến việc hỗ trợ người dùng trong suốt quá
                trình sử dụng. Bạn có thể tham khảo các hướng dẫn, thông tin hữu ích hoặc liên hệ để được tư vấn khi cần
                thiết. Bên cạnh đó, hệ thống đặt hàng và theo dõi đơn hàng cũng được tối ưu để mang lại sự tiện lợi và
                minh bạch.
                <br>
                Với định hướng phát triển lâu dài, KIPEEDA mong muốn trở thành một địa chỉ quen thuộc đối với những ai
                đang tìm kiếm thiết bị công nghệ chất lượng với mức giá hợp lý. Đây không chỉ là nơi mua sắm, mà còn là
                nơi giúp bạn tiếp cận và lựa chọn công nghệ một cách dễ dàng hơn mỗi ngày.

            </div>
        </div>

    </div>

    <?php include "footer.php" ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
</body>

</html>