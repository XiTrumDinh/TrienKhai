<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// chỉ admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}

require_once "Database/Database.php";
$db = new Database();

// ===== GET FILTER =====
$keyword = $_GET['keyword'] ?? '';
$status = $_GET['status'] ?? '';
$sort = $_GET['sort'] ?? 'new';

// ===== UPDATE STATUS =====
if (isset($_POST["updateStatus"])) {
    $id = $_POST["id"];
    $statusUpdate = $_POST["status"];

    // chống hack
    $allowed = ['pending', 'confirmed', 'shipping', 'completed'];
    if (!in_array($statusUpdate, $allowed))
        die("Invalid status");

    $sql = "UPDATE orders SET status=? WHERE id=?";
    $stmt = $db->conn->prepare($sql);

    if (!$stmt) {
        die("SQL lỗi: " . $db->conn->error);
    }
    $stmt->bind_param("si", $statusUpdate, $id);
    $stmt->execute();

    header("Location: order.php");
    exit();
}

// ===== BUILD QUERY =====
$sql = "SELECT * FROM orders WHERE 1";
$params = [];
$types = "";

// SEARCH
if (!empty($keyword)) {
    $sql .= " AND (name LIKE ? OR phone LIKE ?)";
    $kw = "%$keyword%";
    $params[] = $kw;
    $params[] = $kw;
    $types .= "ss";
}

// FILTER STATUS
if (!empty($status)) {
    $sql .= " AND status = ?";
    $params[] = $status;
    $types .= "s";
}

// SORT
switch ($sort) {
    case 'old':
        $sql .= " ORDER BY id ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY final_total DESC";
        break;
    case 'price_asc':
        $sql .= " ORDER BY final_total ASC";
        break;
    default:
        $sql .= " ORDER BY id DESC";
}

// RUN QUERY
$stmt = $db->conn->prepare($sql);

if (!$stmt) {
    die("SQL lỗi: " . $db->conn->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
    die("Execute lỗi: " . $stmt->error);
}

$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>

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
                    <li><a href="user.php">User</a></li>
                    <li><a href="crud.php">Product</a></li>
                    <li><a href="order.php" class="active">Order</a></li>
                </ul>
            </div>

            <!-- MAIN -->
            <div class="col-md-10 main-content">

                <h5 class="mb-3">Quản lý đơn hàng</h5>

                <div class="d-flex gap-2 mb-3 flex-wrap">

                    <!-- SEARCH -->
                    <form method="GET" class="flex-grow-1">
                        <div class="input-group">
                            <input type="search" name="keyword" class="form-control" placeholder="Tìm tên, SĐT..."
                                value="<?= htmlspecialchars($keyword) ?>">

                            <button class="btn btn-outline-secondary">🔍</button>
                        </div>
                    </form>

                    <!-- FILTER -->
                    <select id="statusFilter" class="form-select w-auto">
                        <option value="">Tất cả</option>
                        <option value="pending" <?= ($status == 'pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= ($status == 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
                        <option value="shipping" <?= ($status == 'shipping') ? 'selected' : '' ?>>Shipping</option>
                        <option value="complete" <?= ($status == 'completed') ? 'selected' : '' ?>>Complete</option>
                    </select>

                    <!-- SORT -->
                    <select id="sortFilter" class="form-select w-auto">
                        <option value="new" <?= ($sort == 'new') ? 'selected' : '' ?>>Mới nhất</option>
                        <option value="old" <?= ($sort == 'old') ? 'selected' : '' ?>>Cũ nhất</option>
                        <option value="price_desc" <?= ($sort == 'price_desc') ? 'selected' : '' ?>>Giá cao</option>
                        <option value="price_asc" <?= ($sort == 'price_asc') ? 'selected' : '' ?>>Giá thấp</option>
                    </select>

                </div>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Khách</th>
                                <th>SĐT</th>
                                <th>Địa chỉ</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td><?= $o["id"] ?></td>
                                    <td><?= $o["name"] ?></td>
                                    <td><?= $o["phone"] ?></td>
                                    <td><?= $o["address"] ?></td>
                                    <td><?= number_format($o["final_total"]) ?>₫</td>

                                    <!-- STATUS -->
                                    <td>
                                        <?php
                                        switch ($o["status"]) {
                                            case 'pending':
                                                echo '<span class="badge bg-secondary">Pending</span>';
                                                break;
                                            case 'confirmed':
                                                echo '<span class="badge bg-warning">Confirmed</span>';
                                                break;
                                            case 'shipping':
                                                echo '<span class="badge bg-info">Shipping</span>';
                                                break;
                                            case 'completed':
                                                echo '<span class="badge bg-success">Complete</span>';
                                                break;
                                        }
                                        ?>
                                    </td>

                                    <!-- ACTION -->
                                    <td>
                                        <div>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit<?= $o["id"] ?>">
                                                Update
                                            </button>
                                            <a href="order_items.php?id=<?= $o["id"] ?>" class="btn btn-info btn-sm">Chi
                                                Tiết</a>
                                        </div>

                                        <div class="modal fade" id="edit<?= $o["id"] ?>">
                                            <div class="modal-dialog">
                                                <form method="POST">
                                                    <div class="modal-content p-3">
                                                        <h5>Cập nhật trạng thái</h5>

                                                        <input type="hidden" name="id" value="<?= $o["id"] ?>">

                                                        <select name="status" class="form-control mb-3">
                                                            <option value="pending" <?= $o["status"] == "pending" ? "selected" : "" ?>>Pending</option>
                                                            <option value="confirmed" <?= $o["status"] == "confirmed" ? "selected" : "" ?>>Confirmed</option>
                                                            <option value="shipping" <?= $o["status"] == "shipping" ? "selected" : "" ?>>Shipping</option>
                                                            <option value="completed" <?= $o["status"] == "completed" ? "selected" : "" ?>>Complete</option>
                                                        </select>

                                                        <button name="updateStatus" class="btn btn-primary">Lưu</button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="public/js/footer.js"></script>
    <script src="public/js/CRUD.js"></script>

    <!-- FILTER + SORT JS -->
    <script>
        const statusFilter = document.getElementById("statusFilter");
        const sortFilter = document.getElementById("sortFilter");

        function updateURL() {
            const url = new URL(window.location.href);

            if (statusFilter.value) {
                url.searchParams.set("status", statusFilter.value);
            } else {
                url.searchParams.delete("status");
            }

            if (sortFilter.value) {
                url.searchParams.set("sort", sortFilter.value);
            }

            window.location.href = url.toString();
        }

        statusFilter.addEventListener("change", updateURL);
        sortFilter.addEventListener("change", updateURL);
    </script>

</body>

</html>