<?php
require_once "Database/Database.php";
$category = $_GET['category'] ?? null;
$page = $_GET['page'] ?? 1;
$db = new Database();

$limit = 10;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$currentPage = $page;
$offset = ($page - 1) * $limit;
/* Lấy danh mục mới nhất */
$categories = $db->select("SELECT * FROM categories");
/* Lấy sản phẩm mới nhất */
if ($category) {

    $products = $db->select(
        "SELECT * FROM products
WHERE category_id = ?
AND flash_sale = 0
ORDER BY created_at DESC
LIMIT $offset, $limit",
        "i",
        [$category]
    );
} else {

    $products = $db->select(
        "SELECT * FROM products
WHERE flash_sale = 0
ORDER BY created_at DESC
LIMIT $offset, $limit"
    );
}

/* tổng sản phẩm */
if ($category) {
    $total = $db->count("SELECT COUNT(*) FROM products WHERE category_id=$category AND flash_sale=0");
} else {
    $total = $db->count("SELECT COUNT(*) FROM products WHERE flash_sale=0");
}

/* tổng trang */
$totalPage = ceil($total / $limit);
$flash = $db->select(
    "SELECT * FROM products 
WHERE flash_sale = 1 
LIMIT 4"
);
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

</head>

<body>

    <!-- Navbar -->
    <?php include_once "navbar.php"; ?>

    <div class="container">
        <div class="home-banner">

            <!-- MENU -->
            <div id="overlay"></div>
            <div class="menu" id="bannerMenu">
                <ul>

                    <?php foreach ($categories as $c): ?>

                        <li class="<?= ($category == $c['id']) ? 'active' : '' ?>">

                            <a href="view.php?category=<?= $c['id'] ?>">

                                <?= $c['name'] ?>

                            </a>

                        </li>

                    <?php endforeach ?>

                </ul>
            </div>

            <!-- BANNER LỚN -->
            <div class="banner big">
                <img src="public/img/big_banner1.jpg">
            </div>

            <!-- BANNER PHẢI -->
            <div class="banner right1">
                <img src="public/img/big_banner2.jpg">
            </div>

            <div class="banner right2">
                <img src="public/img/big_banner3.jpg">
            </div>

            <!-- BANNER DƯỚI -->
            <div class="banner bottom1">
                <img src="public/img/big_banner4.jpg">
            </div>

            <div class="banner bottom2">
                <img src="public/img/big_banner5.jpg">
            </div>

            <div class="banner bottom3">
                <img src="public/img/big_banner6.jpg">
            </div>

        </div>
    </div>



    <!-- Flash Sale -->

    <section class="container mt-4 ">

        <div class="flash-sale">
            <div class="flash-title">
                <h3><b>⚡ Siêu sale giữa tháng - Chốt deal hời ⚡</b></h3>
            </div>
            <!-- banner trái -->
            <div class="flash-left">
                <img src="public/img/flash_sale1.jpg">
            </div>

            <!-- sản phẩm -->
            <?php foreach ($flash as $f): ?>

                <div class="product-card" data-id="<?= $f['id'] ?>">

                    <div class="flash-tag">FLASH SALE</div>

                    <img src="public/img/<?= $f['image'] ?>">

                    <p class="mt-5"><?= $f['name'] ?></p>

                    <div class="old"><?= number_format($f['price'], 0, ',', '.') ?> đ</div>

                    <div class="price-row">

                        <span class="new">
                            <?= number_format($f['old_price'], 0, ',', '.') ?> đ
                        </span>

                        <?php
                        $percent = round((($f['old_price'] - $f['price']) / $f['old_price']) * 100);
                        ?>

                        <span class="sale"><?= $percent ?>%</span>

                    </div>

                    <div class="rating">
                        ⭐ 0.0 (0 đánh giá)
                    </div>

                    <button>MUA NGAY</button>

                </div>

            <?php endforeach ?>
            <script>
                document.querySelectorAll(".product-card").forEach(card => {

                    card.addEventListener("click", function() {

                        let id = this.dataset.id

                        window.location.href = "descript.php?id=" + id

                    })

                })
            </script>
            <div class="flash-more">
                Xem thêm ưu đãi
            </div>


    </section>
    <br>

    <!-- Banner Khueyen mai -->
    <section class="container">
        <div class="promo-wrapper">

            <div class="promo-banner">
                <img src="public/img/banner1.jpg">
            </div>

            <div class="promo-banner">
                <img src="public/img/banner2.jpg">
            </div>

        </div>
    </section>


    <!-- Sản phẩm -->

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



    <div class="text-center mt-4 mb-4">
        <a href="view.php"
            class="btn btn-danger px-4 py-2">
            Xem thêm
        </a>
    </div>
    <!-- Footer -->
    <?php include "footer.php" ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public\js\footer.js"></script>
    <script src="public\js\index.js"></script>
</body>

</html>