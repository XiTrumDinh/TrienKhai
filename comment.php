
<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require_once "Database/Database.php";
$db = new Database();

$order_id = $_GET['id'] ?? 0;
$user_id = $_SESSION['id'];

// ===== LẤY ORDER =====
$order = $db->select(
    "SELECT * FROM orders WHERE id = ? AND user_id = ?",
    "ii",
    [$order_id, $user_id]
);

if (empty($order)) {
    die("Không tìm thấy đơn hàng");
}

$order = $order[0];

// ===== LẤY ITEMS =====
$sql = "SELECT oi.*, p.name, p.image 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?";

$items = $db->select($sql, "i", [$order_id]);

// ===== SUBMIT REVIEW =====
if (isset($_POST['submit_review'])) {

    $order_item_id = $_POST['order_item_id'];
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // check đã review chưa
    $check = $db->select(
        "SELECT id FROM reviews WHERE order_item_id = ?",
        "i",
        [$order_item_id]
    );

    if (!empty($check)) {
        // update
        $sql = "UPDATE reviews SET rating = ?, comment = ? WHERE order_item_id = ?";
        $db->execute($sql, "isi", [$rating, $comment, $order_item_id]);
    } else {
        // insert
        $sql = "INSERT INTO reviews (user_id, product_id, order_item_id, rating, comment)
                VALUES (?, ?, ?, ?, ?)";
        $db->execute($sql, "iiiis", [$user_id, $product_id, $order_item_id, $rating, $comment]);
    }

    header("Location: comment.php?id=" . $order_id);
    exit();
}


?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/comment.css">

</head>

<body>

    <?php include "navbar.php"; ?>
    <div class="order-container">
        <div class="order-box">

            <a href="completed.php" class="back-btn">← Quay lại</a>

            <h4>Đơn hàng #<?= $order['id'] ?></h4>

            <div class="order-status mb-3">
                Trạng thái: <b><?= $order['status'] ?></b>
            </div>

            <!-- LIST PRODUCT -->
            <?php foreach ($items as $i):

                $review = $db->select(
                    "SELECT * FROM reviews WHERE order_item_id = ?",
                    "i",
                    [$i['id']]
                );

                $review = $review[0] ?? null;
                ?>

                <div class="product-item">

                    <img src="public/img/<?= $i['image'] ?>" class="product-img">

                    <div class="product-info">
                        <h5><?= $i['name'] ?></h5>
                        <span>x<?= $i['quantity'] ?></span>

                        <?php if ($order['status'] == 'completed'): ?>

                            <?php if ($review && !isset($_GET['edit_' . $i['id']])): ?>

                                <!-- HIỂN THỊ -->
                                <div class="mt-2">
                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                        <?= $s <= $review['rating'] ? '⭐' : '☆' ?>
                                    <?php endfor; ?>

                                    <p><?= $review['comment'] ?></p>

                                    <a href="?id=<?= $order_id ?>&edit_<?= $i['id'] ?>=1" class="btn btn-sm btn-primary">
                                        Sửa
                                    </a>
                                </div>

                            <?php else: ?>

                                <!-- FORM -->
                                <form method="POST" class="mt-2">

                                    <input type="hidden" name="order_item_id" value="<?= $i['id'] ?>">
                                    <input type="hidden" name="product_id" value="<?= $i['product_id'] ?>">

                                    <div class="rating mb-2">
                                        <?php for ($s = 5; $s >= 1; $s--): ?>
                                            <input type="radio" name="rating" value="<?= $s ?>" id="star<?= $i['id'] . $s ?>" required>
                                            <label for="star<?= $i['id'] . $s ?>">★</label>
                                        <?php endfor; ?>
                                    </div>

                                    <textarea name="comment" class="form-control mb-2"
                                        placeholder="Nhận xét (không bắt buộc)..."><?= $review['comment'] ?? '' ?></textarea>

                                    <button name="submit_review" class="btn btn-success btn-sm">
                                        <?= $review ? 'Cập nhật' : 'Gửi đánh giá' ?>
                                    </button>

                                </form>

                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                    <div class="product-price">
                        <?= number_format($i['price']) ?>₫
                    </div>

                </div>

            <?php endforeach; ?>

            <!-- TOTAL -->
            <div class="total-box">
                <div class="total-row">
                    <span>Tổng tiền</span>
                    <span><?= number_format($order['total']) ?>₫</span>
                </div>

                <div class="total-row">
                    <span>Giảm giá</span>
                    <span><?= number_format($order['discount']) ?>₫</span>
                </div>

                <div class="total-final">
                    <span> Thanh toán</span>
                    <span><?= number_format($order['final_total']) ?>₫</span>

                </div>
            </div>

        </div>
    </div>


    <?php include "footer.php" ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
</body>

</html>