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
    <link rel="stylesheet" href="public/css/crud.css">

</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="container-fluid mt-3">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-2 sidebar">
                <h6>Quản lý CRUD</h6>
                <hr>
                <ul class="list-unstyled">
                    <li><a href="#">User</a></li>
                    <li><a href="#" class="active">Product</a></li>
                    <li>.....</li>
                    <li>.....</li>
                </ul>

            </div>

            <!-- MAIN CONTENT -->
            <div class="col-md-10 main-content">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>CRUD - Product</h5>
                </div>
                <div class="d-flex gap-2 mb-3 flex-wrap">

                    <!-- SEARCH -->

                    <form action="" class="search-box flex-grow-1 d-flex align-items-center">
                        <input class="form-control" type="search" placeholder="Bạn cần tìm gì?">

                        <svg class="search-icon ms-2" width="18" height="18" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"><!--!Font Awesome Free v5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path
                                d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
                        </svg>
                    </form>

                    <!-- FILTER LOẠI -->
                    <select id="categoryFilter" class="form-select w-auto">
                        <option value="">Tất cả</option>
                        <option value="laptop">Laptop</option>
                        <option value="pc">PC</option>
                        <option value="ram">RAM</option>
                    </select>
                    <button class="btn btn-success">+ Thêm sản phẩm</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID ↑↓</th>
                                <th>Tên sản phẩm ↑↓</th>
                                <th>Giá cũ ↑↓</th>
                                <th>Giá mới ↑↓</th>
                                <th>Mô tả</th>
                                <th>Mô tả ngắn</th>
                                <th>Ngày tạo ↑↓</th>
                                <th>Hình ảnh</th>
                                <th>Flash Sale</th>
                                <th>Ẩn/Hiện</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>Laptop1</td>
                                <td>30.000.000</td>
                                <td>25.000.000</td>
                                <td class="limit-50">
                                    Laptop ASUS Vivobook 15 OLED sở hữu thiết kế mỏng nhẹ, màn hình OLED rực rỡ cùng
                                    hiệu năng mạnh mẽ từ Intel Core i5, phù hợp cho học tập và làm việc văn phòng.
                                </td>
                                <td>Intel Core i5 | 16GB RAM | 512GB SSD | OLED</td>
                                <td>2026-03-15 23:56:33</td>
                                <td>
                                    <img src="public/img/laptop1.jpg" width="60">
                                </td>
                                <td>
                                    <input type="checkbox" class="flash-sale">
                                </td>

                                <td>
                                    <input type="checkbox" class="status" checked>
                                </td>

                                <td>
                                    <button class="action-btn btn-edit">Edit</button><br>
                                    <button class="action-btn btn-delete">Delete</button>
                                </td>

                            </tr>

                            <tr>
                                <td>1</td>
                                <td>Laptop1</td>
                                <td>30.000.000</td>
                                <td>25.000.000</td>
                                <td class="limit-50">
                                    Laptop ASUS Vivobook 15 OLED sở hữu thiết kế mỏng nhẹ, màn hình OLED rực rỡ cùng
                                    hiệu năng mạnh mẽ từ Intel Core i5, phù hợp cho học tập và làm việc văn phòng.
                                </td>
                                <td>Intel Core i5 | 16GB RAM | 512GB SSD | OLED</td>
                                <td>2026-03-15 23:56:33</td>
                                <td>
                                    <img src="public/img/laptop1.jpg" width="60">
                                </td>
                                <td>
                                    <input type="checkbox" class="flash-sale">
                                </td>

                                <td>
                                    <input type="checkbox" class="status" checked>
                                </td>

                                <td>
                                    <button class="action-btn btn-edit">Edit</button><br>
                                    <button class="action-btn btn-delete">Delete</button>
                                </td>

                            </tr>


                            <tr>
                                <td>1</td>
                                <td>Laptop1</td>
                                <td>30.000.000</td>
                                <td>25.000.000</td>
                                <td class="limit-50">
                                    Laptop ASUS Vivobook 15 OLED sở hữu thiết kế mỏng nhẹ, màn hình OLED rực rỡ cùng
                                    hiệu năng mạnh mẽ từ Intel Core i5, phù hợp cho học tập và làm việc văn phòng.
                                </td>
                                <td>Intel Core i5 | 16GB RAM | 512GB SSD | OLED</td>
                                <td>2026-03-15 23:56:33</td>
                                <td>
                                    <img src="public/img/laptop1.jpg" width="60">
                                </td>
                                <td>
                                    <input type="checkbox" class="flash-sale">
                                </td>

                                <td>
                                    <input type="checkbox" class="status" checked>
                                </td>

                                <td>
                                    <button class="action-btn btn-edit">Edit</button><br>
                                    <button class="action-btn btn-delete">Delete</button>
                                </td>

                            </tr>


                            <tr>
                                <td>1</td>
                                <td>Laptop1</td>
                                <td>30.000.000</td>
                                <td>25.000.000</td>
                                <td class="limit-50">
                                    Laptop ASUS Vivobook 15 OLED sở hữu thiết kế mỏng nhẹ, màn hình OLED rực rỡ cùng
                                    hiệu năng mạnh mẽ từ Intel Core i5, phù hợp cho học tập và làm việc văn phòng.
                                </td>
                                <td>Intel Core i5 | 16GB RAM | 512GB SSD | OLED</td>
                                <td>2026-03-15 23:56:33</td>
                                <td>
                                    <img src="public/img/laptop1.jpg" width="60">
                                </td>
                                <td>
                                    <input type="checkbox" class="flash-sale">
                                </td>

                                <td>
                                    <input type="checkbox" class="status" checked>
                                </td>

                                <td>
                                    <button class="action-btn btn-edit">Edit</button><br>
                                    <button class="action-btn btn-delete">Delete</button>
                                </td>

                            </tr>


                            <tr>
                                <td>1</td>
                                <td>Laptop1</td>
                                <td>30.000.000</td>
                                <td>25.000.000</td>
                                <td class="limit-50">
                                    Laptop ASUS Vivobook 15 OLED sở hữu thiết kế mỏng nhẹ, màn hình OLED rực rỡ cùng
                                    hiệu năng mạnh mẽ từ Intel Core i5, phù hợp cho học tập và làm việc văn phòng.
                                </td>
                                <td>Intel Core i5 | 16GB RAM | 512GB SSD | OLED</td>
                                <td>2026-03-15 23:56:33</td>
                                <td>
                                    <img src="public/img/laptop1.jpg" width="60">
                                </td>
                                <td>
                                    <input type="checkbox" class="flash-sale">
                                </td>

                                <td>
                                    <input type="checkbox" class="status" checked>
                                </td>

                                <td>
                                    <button class="action-btn btn-edit">Edit</button><br>
                                    <button class="action-btn btn-delete">Delete</button>
                                </td>

                            </tr>


                        </tbody>


                    </table>

                </div>
                <div class="pagination">

                    <a class="page-btn" href="#">«</a>

                    <a class="page-btn active" href="#">1</a>
                    <a class="page-btn" href="#">2</a>
                    <a class="page-btn" href="#">3</a>
                    <a class="page-btn" href="#">4</a>
                    <a class="page-btn" href="#">5</a>

                    <a class="page-btn" href="#">»</a>

                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
    <script src="public/js/CRUD.js"></script>
</body>

</html>