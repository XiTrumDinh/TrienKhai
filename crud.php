<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// không phải admin -> chặn
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}
require_once "Database/Database.php";

$db = new Database();

// Lấy danh sách danh mục để dùng cho form Thêm/Sửa và tránh lỗi "cannot be null"
$categories = $db->select("SELECT * FROM categories", "", []);

// XỬ LÝ THÊM SẢN PHẨM (ADD)
if (isset($_POST['addProduct'])) {

    $flash = isset($_POST['flash_sale']) ? 1 : 0;
    $status = isset($_POST['status']) ? 1 : 0;

    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "public/img/" . $image);

    // Kiểm tra và lấy category_id từ form để tránh lỗi Undefined
    $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== "" ? $_POST['category_id'] : null;

    if ($category_id === null) {
        echo "<script>alert('Vui lòng chọn danh mục cho sản phẩm!'); window.history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO products (name, old_price, price, description, short_description, image, flash_sale, status, category_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $db->execute($sql, "siisssiii", [
        $_POST['name'],
        $_POST['old_price'],
        $_POST['price'],
        $_POST['description'],
        $_POST['short_description'],
        $image,
        $flash,
        $status,
        $category_id
    ]);

    header("Location: crud.php");
    exit();
}

// XỬ LÝ XÓA SẢN PHẨM (DELETE)
if (isset($_GET['delete'])) {
    $sql = "DELETE FROM products WHERE id = ?";
    $db->execute($sql, "i", [$_GET['delete']]);

    header("Location: crud.php");
    exit();
}

// XỬ LÝ CẬP NHẬT SẢN PHẨM (UPDATE)
if (isset($_POST['updateProduct'])) {

    $flash = isset($_POST['flash_sale']) ? 1 : 0;
    $status = isset($_POST['status']) ? 1 : 0;
    $image = $_FILES['image']['name'];

    // Kiểm tra category_id khi sửa
    $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== "" ? $_POST['category_id'] : null;

    if ($category_id === null) {
        echo "<script>alert('Vui lòng chọn danh mục cho sản phẩm!'); window.history.back();</script>";
        exit();
    }

    if ($image != "") {
        move_uploaded_file($_FILES['image']['tmp_name'], "public/img/" . $image);

        $sql = "UPDATE products 
                SET name=?, old_price=?, price=?, description=?, short_description=?, image=?, flash_sale=?, status=?, category_id=? 
                WHERE id=?";

        $db->execute($sql, "siisssiiii", [
            $_POST['name'],
            $_POST['old_price'],
            $_POST['price'],
            $_POST['description'],
            $_POST['short_description'],
            $image,
            $flash,
            $status,
            $category_id,
            $_POST['id']
        ]);
    } else {
        $sql = "UPDATE products 
                SET name=?, old_price=?, price=?, description=?, short_description=?, flash_sale=?, status=?, category_id=? 
                WHERE id=?";

        $db->execute($sql, "siissiiii", [
            $_POST['name'],
            $_POST['old_price'],
            $_POST['price'],
            $_POST['description'],
            $_POST['short_description'],
            $flash,
            $status,
            $category_id,
            $_POST['id']
        ]);
    }

    header("Location: crud.php");
    exit();
}

// XỬ LÝ ĐĂNG NHẬP
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username'])) {
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

$keyword = "";
// chỉ nhận keyword khi ở trang crud.php và có submit từ form
if (isset($_GET['keyword']) && isset($_GET['from']) && $_GET['from'] === 'crud') {
    $keyword = trim($_GET['keyword']);
}

// LẤY CATEGORY ĐỂ LỌC
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
if ($page < 1) $page = 1;

$where = [];
$params = [];
$types = "";

// 1. Search theo name
if ($keyword != "") {
    $where[] = "products.name LIKE ?";
    $params[] = "%$keyword%";
    $types .= "s";
}

// 2. Lọc theo danh mục (MỚI THÊM)
if ($category_filter != "") {
    $where[] = "products.category_id = ?";
    $params[] = $category_filter;
    $types .= "i";
}

// Ghép WHERE
$whereSql = "";
if (!empty($where)) {
    $whereSql = "WHERE " . implode(" AND ", $where);
}

// Count tổng số bản ghi (phải khớp với điều kiện lọc)
$totalData = $db->select(
    "SELECT COUNT(*) as total FROM products $whereSql",
    $types,
    $params
);

$total = $totalData[0]['total'];
$totalPages = ceil($total / $limit);
if ($totalPages < 1) $totalPages = 1;
if ($page > $totalPages) $page = $totalPages;

$offset = ($page - 1) * $limit;

// Query lấy dữ liệu chính xác
$selectParams = $params;
$selectTypes = $types;

$sql = "SELECT products.*, categories.name AS category_name 
        FROM products 
        LEFT JOIN categories ON products.category_id = categories.id
        $whereSql
        ORDER BY products.id DESC
        LIMIT $offset, $limit";

$products = $db->select($sql, $selectTypes, $selectParams);
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

            <div class="col-md-2 sidebar">
                <h6>Quản lý CRUD</h6>
                <hr>
                <ul class="list-unstyled">
                    <li><a href="user.php">User</a></li>
                    <li><a href="crud.php" class="active">Product</a></li>
                    <li>.....</li>
                    <li>.....</li>
                </ul>

            </div>

            <div class="col-md-10 main-content">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>CRUD - Product</h5>
                </div>
                <div class="d-flex gap-2 mb-3 flex-wrap">

                    <form method="GET" action="crud.php" class="flex-grow-1">
                        <div class="input-group">

                            <input type="hidden" name="from" value="crud"> <input
                                type="search"
                                name="keyword"
                                class="form-control"
                                placeholder="Tìm sản phẩm..."
                                value="<?= htmlspecialchars($keyword) ?>">

                            <button class="btn btn-outline-secondary" type="submit">
                                🔍
                            </button>

                        </div>
                    </form>

                    <?php
                    $current_cat = isset($_GET['category']) ? $_GET['category'] : '';
                    ?>

                    <select id="categoryFilter"
                        class="form-select w-auto"
                        onchange="filterCategory(this.value)">

                        <option value="">Tất cả danh mục</option>

                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= ($current_cat == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                        + Thêm sản phẩm
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá cũ</th>
                                <th>Giá mới</th>
                                <th>Mô tả</th>
                                <th>Mô tả ngắn</th>
                                <th>Ngày tạo</th>
                                <th>Hình ảnh</th>
                                <th>Flash Sale</th>
                                <th>Ẩn/Hiện</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($products as $item): ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($item['category_name'] ?? 'Chưa phân loại') ?>
                                        </span>
                                    </td>
                                    <td><?= number_format($item['old_price']) ?></td>
                                    <td><?= number_format($item['price']) ?></td>
                                    <td class="limit-50"><?= $item['description'] ?></td>
                                    <td><?= $item['short_description'] ?></td>
                                    <td><?= $item['created_at'] ?></td>
                                    <td>
                                        <img src="public/img/<?= $item['image'] ?>" width="60">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $item['flash_sale'] ? 'checked' : '' ?> disabled>
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $item['status'] ? 'checked' : '' ?> disabled>
                                    </td>
                                    <td>

                                        <button class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit<?= $item['id'] ?>">
                                            Edit
                                        </button>

                                        <div class="modal fade" id="edit<?= $item['id'] ?>">
                                            <div class="modal-dialog">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="modal-content p-3 text-start">
                                                        <h5>Sửa sản phẩm</h5>

                                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">

                                                        <label class="mb-1 small text-secondary">Tên sản phẩm</label>
                                                        <input type="text" name="name" class="form-control mb-2"
                                                            value="<?= $item['name'] ?>" required>

                                                        <label class="mb-1 small text-secondary">Giá cũ</label>
                                                        <input type="number" name="old_price" class="form-control mb-2"
                                                            value="<?= $item['old_price'] ?>">

                                                        <label class="mb-1 small text-secondary">Giá mới</label>
                                                        <input type="number" name="price" class="form-control mb-2"
                                                            value="<?= $item['price'] ?>" required>

                                                        <label class="mb-1 small text-secondary">Mô tả</label>
                                                        <textarea name="description" class="form-control mb-2"><?= $item['description'] ?></textarea>

                                                        <label class="mb-1 small text-secondary">Mô tả ngắn</label>
                                                        <input type="text" name="short_description" class="form-control mb-2"
                                                            value="<?= $item['short_description'] ?>">

                                                        <label class="mb-1 small text-secondary">Ảnh sản phẩm</label>
                                                        <input type="file" name="image" class="form-control mb-2">

                                                        <label class="mb-1 small text-secondary">Danh mục <span class="text-danger">*</span></label>
                                                        <select name="category_id" class="form-select mb-2" required>
                                                            <option value="">-- Chọn danh mục --</option>
                                                            <?php foreach ($categories as $cat): ?>
                                                                <option value="<?= $cat['id'] ?>" <?= (isset($item['category_id']) && $item['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                                                    <?= $cat['name'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>

                                                        <label>
                                                            <input type="checkbox" name="flash_sale" value="1"
                                                                <?= $item['flash_sale'] ? 'checked' : '' ?>>
                                                            Flash Sale
                                                        </label>

                                                        <label class="ms-3">
                                                            <input type="checkbox" name="status" value="1"
                                                                <?= $item['status'] ? 'checked' : '' ?>>
                                                            Hiển thị
                                                        </label>

                                                        <br><br>

                                                        <button name="updateProduct" class="btn btn-primary">Cập nhật</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <br>

                                        <a href="?delete=<?= $item['id'] ?>"
                                            class="btn btn-danger btn-sm mt-1"
                                            onclick="return confirm('Xóa sản phẩm này?')">
                                            Delete
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>

                </div>
                <div class="pagination">

                    <?php if ($page > 1): ?>
                        <a class="page-btn"
                            href="?page=<?= $page - 1 ?>&keyword=<?= urlencode($keyword) ?>&category=<?= $category_filter ?>&from=crud">
                            «
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a class="page-btn <?= ($i == $page) ? 'active' : '' ?>"
                            href="?page=<?= $i ?>&keyword=<?= urlencode($keyword) ?>&category=<?= $category_filter ?>&from=crud">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a class="page-btn"
                            href="?page=<?= $page + 1 ?>&keyword=<?= urlencode($keyword) ?>&category=<?= $category_filter ?>&from=crud">
                            »
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
    <script src="public/js/CRUD.js"></script>
</body>

<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data">
            <div class="modal-content p-3">
                <h5>Thêm sản phẩm</h5>

                <input type="text" name="name" class="form-control mb-2" placeholder="Tên sản phẩm" required>

                <input type="number" name="old_price" class="form-control mb-2" placeholder="Giá cũ">

                <input type="number" name="price" class="form-control mb-2" placeholder="Giá mới" required>

                <textarea name="description" class="form-control mb-2" placeholder="Mô tả"></textarea>

                <input type="text" name="short_description" class="form-control mb-2" placeholder="Mô tả ngắn">

                <input type="file" name="image" class="form-control mb-2">

                <select name="category_id" class="form-select mb-2" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label>
                    <input type="checkbox" name="flash_sale" value="1"> Flash Sale
                </label>

                <label class="ms-3">
                    <input type="checkbox" name="status" value="1" checked> Hiển thị
                </label>

                <br><br>

                <button name="addProduct" class="btn btn-success">Thêm</button>
            </div>
        </form>
    </div>
</div>
<script>
    function filterCategory(catId) {
        const url = new URL(window.location.href);

        if (catId) {
            url.searchParams.set("category", catId);
        } else {
            url.searchParams.delete("category");
        }

        url.searchParams.set("page", 1);
        url.searchParams.set("from", "crud");

        window.location.href = url.toString();
    }
</script>

</html>