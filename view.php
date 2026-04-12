<?php
require_once "Database/Database.php";

$category = $_GET['category'] ?? null;
$keyword = $_GET['keyword'] ?? "";
$page = $_GET['page'] ?? 1;
$flash = $_GET['flash'] ?? null;
$db = new Database();

/*  FIX SEARCH  */
if (!empty($keyword)) {
    $category = null;
}

/*  BANNER  */
$defaultBanner = "banner1.jpg";

if (!empty($keyword)) {
    $banner = $defaultBanner;
} else if (!empty($category)) {
    $result = $db->select(
        "SELECT image FROM categories WHERE id = ?",
        "i",
        [$category]
    );
    $banner = $result[0]['image'] ?? $defaultBanner;
} else {
    $banner = $defaultBanner;
}

/*  PAGINATION  */
$limit = 10;
$page = (int) $page;
if ($page < 1)
    $page = 1;

$offset = ($page - 1) * $limit;



/*  QUERY  */
$sql = "
SELECT 
    p.*,
    IFNULL(r.avg_rating, 0) AS avg_rating,
    IFNULL(r.total_review, 0) AS total_review
FROM products p
LEFT JOIN (
    SELECT 
        product_id,
        AVG(rating) AS avg_rating,
        COUNT(*) AS total_review
    FROM reviews
    GROUP BY product_id
) r ON p.id = r.product_id
WHERE p.status = '0'
";

$sqlCount = "
SELECT COUNT(*) FROM products 
WHERE status = '0'
";

/* ===== filter flash sale ===== */
if ($flash) {
    $sql .= " AND p.flash_sale = '1'";
    $sqlCount .= " AND flash_sale = '1'";
}

$params = [];
$types = "";

/* ===== filter category ===== */
if ($category) {
    $sql .= " AND p.category_id = ?";
    $sqlCount .= " AND category_id = ?";
    $params[] = $category;
    $types .= "i";
}

/* ===== filter keyword ===== */
if ($keyword) {
    $sql .= " AND p.name LIKE ?";
    $sqlCount .= " AND name LIKE ?";
    $params[] = "%$keyword%";
    $types .= "s";
}

/* ===== order + limit ===== */
$sql .= " ORDER BY p.created_at DESC LIMIT $offset, $limit";

/* ===== query ===== */
$products = $db->select($sql, $types, $params);

/* ===== total ===== */
$total = $db->count($sqlCount, $types, $params);
$totalPage = ceil($total / $limit);
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
            <img src="public/img/<?= $banner ?>" alt="Banner">
        </div>
    </div>

    <!--  PRODUCT LIST  -->
    <section class="product-list container">

        <?php if (!empty($products)): ?>

            <?php foreach ($products as $p): ?>

                <?php
                $avg = $p['avg_rating'] ? round($p['avg_rating'], 1) : 0;
                $count = $p['total_review'] ?? 0;
                $full = floor($avg);
                ?>

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
                            $percent = ($p['old_price'] > 0)
                                ? round((($p['old_price'] - $p['price']) / $p['old_price']) * 100)
                                : 0;
                            ?>

                            <span class="sale">-<?= $percent ?>%</span>

                        </div>

                        <!-- ⭐ RATING -->
                        <div class="rating">

                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?= ($i <= $full) ? "⭐" : "☆" ?>
                            <?php endfor; ?>

                            <span>
                                <?= number_format($avg, 1) ?> (<?= $count ?>)
                            </span>

                        </div>

                    </div>

                </a>

            <?php endforeach; ?>

        <?php else: ?>
            <p style="text-align:center;">Không có sản phẩm</p>
        <?php endif; ?>

    </section>

    <!-- PAGINATION -->
    <div class="pagination text-center mt-4">

        <!-- Prev -->
        <a href="?category=<?= $category ?>&keyword=<?= $keyword ?>&page=<?= max(1, $page - 1) ?>">«</a>

        <!-- Number -->
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a class="<?= ($i == $page) ? 'active' : '' ?>"
                href="?category=<?= $category ?>&keyword=<?= $keyword ?>&page=<?= $i ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

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