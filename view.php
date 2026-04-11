
<?php
require_once "Database/Database.php";
$category = $_GET['category'] ?? null;
$keyword = $_GET['keyword'] ?? "";
$page = $_GET['page'] ?? 1;

$db = new Database();

$limit = 10;
$page = (int)$page;
$offset = ($page - 1) * $limit;

/* BUILD QUERY */
$sql = "SELECT * FROM products WHERE flash_sale = 0";
$sqlCount = "SELECT COUNT(*) FROM products WHERE flash_sale = 0";

$params = [];
$types = "";

/* filter category */
if ($category) {
    $sql .= " AND category_id = ?";
    $sqlCount .= " AND category_id = ?";
    $params[] = $category;
    $types .= "i";
}

/* filter keyword */
if ($keyword) {
    $sql .= " AND name LIKE ?";
    $sqlCount .= " AND name LIKE ?";
    $params[] = "%$keyword%";
    $types .= "s";
}

/* order + limit */
$sql .= " ORDER BY created_at DESC LIMIT $offset, $limit";

/* query */
$products = $db->select($sql, $types, $params);

/* total */
$total = $db->count($sqlCount, $types, $params);

/* total page */
$totalPage = ceil($total / $limit);
/*Doi anh */
$banner = $db->select("SELECT image FROM categories LIMIT 1")[0]['image'];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PC Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/view.css">

</head>

<body>



    <!-- Navbar -->
    <?php include_once "navbar.php"; ?>
    <br>
    <div class="container">
        <div class="banner">
            <img src="public/img/banner1.jpg" alt="Banner">
        </div>
    </div>

    <section class="product-list container">
        <?php foreach ($products as $p): ?>

            <a href="descript.php?id=<?= $p['id'] ?>" class="product-link">

                <div class="product-item">

                    <img src="public/img/<?= $p['image'] ?>">

                    <h4><?= $p['name'] ?></h4>

                    <div class="spec">
                        <?= $p['short_description'] ?>
                    </div>

                    <div class="old">
                        <?= number_format($p['old_price'], 0, ',', '.') ?> ₫
                    </div>

                    <div class="price-row">

                        <span class="new">
                            <?= number_format($p['price'], 0, ',', '.') ?> ₫
                        </span>

                        <?php
                        $percent = round((($p['old_price'] - $p['price']) / $p['old_price']) * 100);
                        ?>

                        <span class="sale">-<?= $percent ?>%</span>

                    </div>

                    <div class="rating">
                        ⭐ 0.0 (0 đánh giá)
                    </div>

                </div>

            </a>

        <?php endforeach ?>


    </section>


    <!-- Phân trang -->
    <div class="pagination">

        <!-- Prev -->
        <a href="?category=<?= $category ?>&keyword=<?= $keyword ?>&page=<?= max(1, $page - 1) ?>">«</a>

        <!-- Number -->
        <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
            <a class="<?= ($i == $page) ? 'active' : '' ?>"
                href="?category=<?= $category ?>&keyword=<?= $keyword ?>&page=<?= $i ?>">
                <?= $i ?>
            </a>
        <?php } ?>

        <!-- Next -->
        <a href="?category=<?= $category ?>&keyword=<?= $keyword ?>&page=<?= min($totalPage, $page + 1) ?>">»</a>

    </div>
    <div id="overlay"></div>
    <!-- Footer -->
    <?php include "footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
</body>

</html>
