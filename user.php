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
// ================= ADD =================
if (isset($_POST["addUser"])) {
    $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
    $db->execute($sql, "ssss", [
        $_POST["username"],
        $_POST["password"],
        $_POST["email"],
        $_POST["role"]
    ]);

    header("Location: user.php");
    exit();
}

// ================= DELETE =================
if (isset($_GET["delete"])) {
    $sql = "DELETE FROM users WHERE id = ?";
    $db->execute($sql, "i", [$_GET["delete"]]);

    header("Location: user.php");
    exit();
}

// ================= UPDATE =================
if (isset($_POST["updateUser"])) {
    $sql = "UPDATE users 
            SET username=?, password=?, email=?, role=? 
            WHERE id=?";
    $db->execute($sql, "ssssi", [
        $_POST["username"],
        $_POST["password"],
        $_POST["email"],
        $_POST["role"],
        $_POST["id"]
    ]);

    header("Location: user.php");
    exit();
}
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

// phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;

if ($page < 1) $page = 1;

// Tổng số record
$total = $db->count("SELECT COUNT(*) FROM users");
$totalPage = ceil($total / $limit);

// Nếu page vượt quá thì set lại
if ($page > $totalPage) $page = $totalPage;

$offset = ($page - 1) * $limit;

// Query có LIMIT
$keyword = isset($_GET['user_keyword']) ? trim($_GET['user_keyword']) : "";
$role = isset($_GET['role']) ? $_GET['role'] : "";

$where = [];
$params = [];
$types = "";

// search
if ($keyword != "") {
    $where[] = "(username LIKE ? OR email LIKE ?)";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
    $types .= "ss";
}

// filter role
if ($role != "") {
    $where[] = "role = ?";
    $params[] = $role;
    $types .= "s";
}

// ghép WHERE
$whereSql = "";
if (!empty($where)) {
    $whereSql = "WHERE " . implode(" AND ", $where);
}

// count
$total = $db->count(
    "SELECT COUNT(*) FROM users $whereSql",
    $types,
    $params
);

$totalPage = ceil($total / $limit);
if ($totalPage < 1) $totalPage = 1;
if ($page > $totalPage) $page = $totalPage;

$offset = ($page - 1) * $limit;

// query
$sql = "SELECT * FROM users 
        $whereSql
        ORDER BY id DESC 
        LIMIT ?, ?";

$params[] = $offset;
$params[] = $limit;
$types .= "ii";

$users = $db->select($sql, $types, $params);

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
                    <li><a href="user.php" class="active">User</a></li>
                    <li><a href="crud.php">Product</a></li>
                    <li>.....</li>
                    <li>.....</li>
                </ul>

            </div>

            <!-- MAIN CONTENT -->
            <div class="col-md-10 main-content">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>CRUD - Users</h5>
                </div>
                <div class="d-flex gap-2 mb-3 flex-wrap">

                    <!-- SEARCH -->

                    <form method="GET" class="flex-grow-1">
                        <div class="input-group">

                            <input
                                type="search"
                                name="user_keyword"
                                class="form-control"
                                placeholder="Tìm user..."
                                value="<?= isset($_GET['user_keyword']) ? $_GET['user_keyword'] : '' ?>">

                            <button class="btn btn-outline-secondary" type="submit">
                                🔍
                            </button>

                        </div>
                    </form>

                    <!-- FILTER LOẠI -->
                    <select id="categoryFilter" class="form-select w-auto">
                        <option value="">Tất cả</option>
                        <option value="admin" <?= (isset($_GET['role']) && $_GET['role'] == 'admin') ? 'selected' : '' ?>>
                            Admin
                        </option>
                        <option value="user" <?= (isset($_GET['role']) && $_GET['role'] == 'user') ? 'selected' : '' ?>>
                            User
                        </option>
                    </select>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        + Thêm User
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID </th>
                                <th>Tên người dùng </th>
                                <th>Mật khẩu </th>
                                <th>Email </th>
                                <th>Role</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $u["id"] ?></td>
                                    <td><?= $u["username"] ?></td>
                                    <td><?= $u["password"] ?></td>
                                    <td><?= $u["email"] ?></td>
                                    <td><?= $u["role"] ?></td>

                                    <td>
                                        <button class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit<?= $u["id"] ?>">
                                            Edit
                                        </button>

                                        <div class="modal fade" id="edit<?= $u["id"] ?>">
                                            <div class="modal-dialog">
                                                <form method="POST">
                                                    <div class="modal-content p-3">
                                                        <h5>Sửa User</h5>

                                                        <input type="hidden" name="id" value="<?= $u["id"] ?>">

                                                        <input type="text" name="username" class="form-control mb-2"
                                                            value="<?= $u["username"] ?>">

                                                        <input type="text" name="password" class="form-control mb-2"
                                                            value="<?= $u["password"] ?>">

                                                        <input type="email" name="email" class="form-control mb-2"
                                                            value="<?= $u["email"] ?>">

                                                        <select name="role" class="form-control mb-2">
                                                            <option value="user" <?= $u["role"] == "user" ? "selected" : "" ?>>User</option>
                                                            <option value="admin" <?= $u["role"] == "admin" ? "selected" : "" ?>>Admin</option>
                                                        </select>

                                                        <button name="updateUser" class="btn btn-primary">Cập nhật</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <a href="?delete=<?= $u["id"] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Xóa user này?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>


                    </table>

                </div>
                <nav>
                    <ul class="pagination justify-content-center">

                        <!-- Prev -->
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="?page=<?= $page - 1 ?>&user_keyword=<?= urlencode($keyword) ?>&role=<?= urlencode($role) ?>">
                                «
                            </a>
                        </li>

                        <!-- Number -->
                        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?page=<?= $i ?>&user_keyword=<?= urlencode($keyword) ?>&role=<?= urlencode($role) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next -->
                        <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="?page=<?= $page + 1 ?>&user_keyword=<?= urlencode($keyword) ?>&role=<?= urlencode($role) ?>">
                                »
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
    <script src="public/js/CRUD.js"></script>
</body>
<div class="modal fade" id="addUserModal">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content p-3">
                <h5>Thêm User</h5>

                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                <input type="text" name="password" class="form-control mb-2" placeholder="Password" required>
                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

                <select name="role" class="form-control mb-2">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>

                <button name="addUser" class="btn btn-success">Thêm</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById("categoryFilter").addEventListener("change", function() {
        let role = this.value;

        let url = new URL(window.location.href);

        if (role) {
            url.searchParams.set("role", role);
        } else {
            url.searchParams.delete("role");
        }

        // giữ lại keyword nếu có
        let keyword = "<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>";
        if (keyword) {
            url.searchParams.set("keyword", keyword);
        }

        // reset về page 1
        url.searchParams.set("page", 1);

        window.location.href = url.toString();
    });
</script>

</html>