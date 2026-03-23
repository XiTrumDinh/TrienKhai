<?php
require_once "Database/Database.php";

$db = new Database();

/* lấy id từ url */
$id = $_GET['id'] ?? 0;

/* lấy sản phẩm */
$product = $db->select(
    "SELECT * FROM products WHERE id = ?",
    "i",
    [$id]
);

/* lấy dòng đầu tiên */
$p = $product[0] ?? null;

$specs = $db->select(
    "SELECT * FROM product_specs WHERE product_id = ?",
    "i",
    [$id]
);

$similar = $db->select(
    "SELECT * FROM products 
     WHERE category_id = ? 
     AND id != ? 
     LIMIT 5",
    "ii",
    [$p['category_id'], $id]
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <title>Document</title>
    <!-- chỉnh phù hợp với máy -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/descript.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
    <!--kết nối navbar-->
    <?php include_once "navbar.php"; ?>

    <br>
    <!--thông tin và đặt hàng-->
    <section class="container mt-4 bg-white ">

        <div class="row g-3">

            <div class="col-lg-6 col-12 text-center ">

                <div class="product-image  p-2 rounded">
                    <img id="main" src="public/img/<?= $p['image'] ?>" class="img-fluid">
                </div>

                <div class="thumb-list mt-3 ">
                    <img src="public/img/<?= $p['image'] ?>" class="thumb" onclick="change(this)">

                </div>

            </div>

            <div class="col-lg-6 col-12 ps-lg-4">
                <h3 class="bg-white p-2"><?= $p['name'] ?></h3>
                <div class="bg-white p-2">
                    <span class="fs-3 fw-bold text-danger"> <?= number_format($p['old_price'], 0, ',', '.') ?> ₫</span>
                    <span class="text-decoration-line-through text-muted ms-2">
                        <?= number_format($p['price'], 0, ',', '.') ?> ₫</span>
                    <?php
                    $percent = round((($p['old_price'] - $p['price']) / $p['old_price']) * 100);
                    ?>
                    <span class="sale">-<?= $percent ?>%</span>
                    <div class="rating">
                        ⭐ 0.0 (0 đánh giá)
                    </div>
                </div>



                <p class="bg-white p-3">
                    Đặc điểm nổi bật
                    <br>
                    <?= $p['description'] ?>
                </p>

                <div class="d-flex gap-3 mt-3">

                    <a href="controller/addtocart.php?id=<?= $p['id'] ?>"
                        class="btn btn-danger px-4 py-2 fw-bold">
                        MUA NGAY
                    </a>

                    <button class="btn btn-outline-danger px-4 py-2">
                        TƯ VẤN NGAY
                    </button>

                </div>
                <div class="bg-white p-3 mt-3 rounded">
                    <p class="text-danger fw-bold">ƯU ĐÃI KHI MUA</p>

                    <p>⭐ Miễn phí vẫn chuyển đối với đơn hàng tỉnh</p>
                    <p>⭐ Giảm 20% cho học sinh, sinh viên</p>
                    <p>⭐ Hỗ trợ trả góp 0%</p>

                </div>
            </div>
        </div>


    </section>
    <section class="container mt-4 bg-white p-4 rounded">

        <h3 class="mb-4">Sản phẩm tương tự</h3>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">

            <?php foreach ($similar as $p): ?>

                <div class="col">

                    <a href="descript.php?id=<?= $p['id'] ?>" class="product-link">

                        <div class="similar-card">

                            <img src="public/img/<?= $p['image'] ?>" class="img-fluid">

                            <h6 class="name">
                                <?= $p['name'] ?>
                            </h6>
                            <div class="old_price">
                                <span class="text-decoration-line-through text-muted ">
                                    <?= number_format($p['price'], 0, ',', '.') ?> ₫</span>
                            </div>
                            <div class="price">
                                <?= number_format($p['price'], 0, ',', '.') ?> ₫
                            </div>

                            <?php
                            $percent = round((($p['old_price'] - $p['price']) / $p['old_price']) * 100);
                            ?>

                            <div class="sale">
                                -<?= $percent ?>%
                            </div>

                        </div>

                    </a>

                </div>

            <?php endforeach ?>

        </div>

    </section>


    <section class="container mt-4 bg-white p-4 rounded">

        <div class="bg-danger text-white text-center p-2 rounded mb-4">
            <h3>Mô tả sản phẩm</h3>
        </div>

        <div class="row g-4">

            <div class="col-lg-8 col-12">

                <div class="p-3 border rounded">
                    <h4>Chi tiết sản phẩm</h4>

                    <p>
                        <?= $p['short_description'] ?>
                    </p>
                    <p>
                        <?= $p['description'] ?>
                    </p>
                </div>

            </div>

            <div class="col-lg-4 col-12">

                <div class="p-3 border rounded">
                    <h4>Thông số</h4>
                    <div class="p-3 border rounded">
                        <h4>Thông số</h4>

                        <table class="table">

                            <?php foreach ($specs as $s): ?>

                                <tr>
                                    <td><?= $s['spec_name'] ?></td>
                                    <td><?= $s['spec_value'] ?></td>
                                </tr>

                            <?php endforeach; ?>

                        </table>
                    </div>
                </div>

                <div class="p-3 border rounded mt-3">
                    <h4>Đánh giá người dùng</h4>
                </div>

            </div>

        </div>

    </section>

    <!--thông tin thêm-->
    <?php include_once "footer.php"; ?>
    <script>
        function change(x) {
            document.getElementById("main").src = x.src;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
</body>

</html>