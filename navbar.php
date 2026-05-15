<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "Database/Database.php";
$db = new Database();

// CHỈ LẤY DANH MỤC ĐỂ HIỂN THỊ MENU - ĐÃ LOẠI BỎ PHẦN SQL PRODUCTS GÂY LỖI
$categories = $db->select("SELECT * FROM categories");

// Lấy keyword để giữ chữ trong ô Search
$keyword = $_GET["keyword"] ?? "";
?>
<link rel="stylesheet" href="public/css/navbar.css">

<nav class="navbar navbar-expand-lg navbar-light bg-danger">
    <div class="container px-3">

        <a class="navbar-brand text-dark" href="index.php">
            <h3 class="m-0">KPD</h3>
        </a>

        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            <?php $isIndex = basename($_SERVER['PHP_SELF']) == "index.php"; ?>

            <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 w-100">

                <?php if ($isIndex): ?>
                    <div class="dropdown">
                        <button type="button" class="btn btn-light dropdown-toggle" id="btnCategory">
                            ☰ Danh mục
                        </button>

                        <ul class="dropdown-menu shadow" id="navMenu">
                            <?php foreach ($categories as $c): ?>
                                <li>
                                    <a class="dropdown-item" href="view.php?category=<?= $c['id'] ?>">
                                        <?= $c['name'] ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php else: ?>


                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                            ☰ Danh mục
                        </button>

                        <ul class="dropdown-menu">
                            <?php foreach ($categories as $c): ?>
                                <li>
                                    <a class="dropdown-item" href="view.php?category=<?= $c['id'] ?>">
                                        <?= $c['name'] ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>

                <?php endif; ?>

                <form action="view.php" method="GET" class="flex-grow-1 ">
                    <div class="input-group">

                        <input type="search" name="keyword" value="<?= htmlspecialchars($keyword) ?>"
                            class="form-control" placeholder="Bạn cần tìm gì?">

                        <button class="btn btn-light" type="submit">
                            🔍
                        </button>

                    </div>
                </form>

                <div class="d-flex flex-column flex-lg-row gap-2">
                    <?php if (isset($_SESSION["role"])): ?>

                        <?php if ($_SESSION["role"] === "admin"): ?>
                            <!-- Admin thấy CRUD và nút Tư vấn nổi bật -->
                            <a href="crud.php" class="btn btn-light">CRUD</a>
                            <a href="text.php" class="btn btn-warning">Tư vấn</a>

                        <?php elseif ($_SESSION["role"] === "quanly"): ?>
                            <!-- Quản lý thấy CRUD và nút Tư vấn bình thường -->
                            <a href="crud.php" class="btn btn-light">CRUD</a>
                            <a href="text.php" class="btn btn-light">Tư vấn</a>

                        <?php else: ?>
                            <!-- Các role khác (như nhân viên tư vấn hoặc user) chỉ thấy nút Tư vấn -->
                            <a href="text.php" class="btn btn-light">Tư vấn</a>
                        <?php endif; ?>

                    <?php endif; ?>
                    <a href="faq.php" class="btn btn-light">Về Chúng Tôi</a></a>

                    <?php if (isset($_SESSION["user"])): ?>

                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2"
                                data-bs-toggle="dropdown" aria-expanded="false">

                                <img src="public/img/avatar/avatar.jpg" height="25px" width="25px" class="rounded-circle">


                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <a class="dropdown-item" href="profile.php">
                                        👤 <span><?= $_SESSION["user"] ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="news.php">
                                        📰 Tin tức
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="cart.php">
                                        🛒 Giỏ hàng
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="shipping.php">
                                        📦 Đơn mua
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="warranty.php">
                                        🛠️ Bảo hành
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <a class="dropdown-item text-danger" href="logout.php">
                                        🚪 Đăng xuất
                                    </a>
                                </li>

                            </ul>
                        </div>

                    <?php else: ?>
                        <div class="d-flex gap-2">
                            <a href="login.php" class="btn btn-light">
                                Đăng nhập
                            </a>

                            <a href="register.php" class="btn btn-light">
                                Đăng ký
                            </a>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
</nav>

<header class="bg-light py-2">
    <div class="container d-flex flex-wrap justify-content-center gap-3">
        <div class="navbar-content">
            <div class="feature-bar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                    <path
                        d="M433.2 103.1L581.4 253.4C609.1 281.5 609.1 326.5 581.4 354.6L425 512.9C415.7 522.3 400.5 522.4 391.1 513.1C381.7 503.8 381.6 488.6 390.9 479.2L547.3 320.8C556.5 311.5 556.5 296.4 547.3 287.1L399 136.9C389.7 127.5 389.8 112.3 399.2 103C408.6 93.7 423.8 93.8 433.1 103.2zM64.1 293.5L64.1 160C64.1 124.7 92.8 96 128.1 96L261.6 96C278.6 96 294.9 102.7 306.9 114.7L450.9 258.7C475.9 283.7 475.9 324.2 450.9 349.2L317.4 482.7C292.4 507.7 251.9 507.7 226.9 482.7L82.9 338.7C70.9 326.7 64.2 310.4 64.2 293.4zM208.1 208C208.1 190.3 193.8 176 176.1 176C158.4 176 144.1 190.3 144.1 208C144.1 225.7 158.4 240 176.1 240C193.8 240 208.1 225.7 208.1 208z" />
                </svg>
                <p>Hot Deal</p>
            </div>
            <p>|</p>
            <div class="feature-bar">
                <a href="news.php"
                    class="d-flex align-items-center gap-2"
                    style="text-decoration: none; color: inherit;">
                    <svg xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path
                            d="M232 144C218.7 144 208 154.7 208 168L208 472C208 480.4 206.6 488.5 203.9 496L504 496C517.3 496 528 485.3 528 472L528 168C528 154.7 517.3 144 504 144L232 144zM136 544C96.2 544 64 511.8 64 472L64 176C64 162.7 74.7 152 88 152C101.3 152 112 162.7 112 176L112 472C112 485.3 122.7 496 136 496C149.3 496 160 485.3 160 472L160 168C160 128.2 192.2 96 232 96L504 96C543.8 96 576 128.2 576 168L576 472C576 511.8 543.8 544 504 544L136 544zM256 216C256 202.7 266.7 192 280 192L328 192C341.3 192 352 202.7 352 216L352 264C352 277.3 341.3 288 328 288L280 288C266.7 288 256 277.3 256 264L256 216zM408 240L456 240C469.3 240 480 250.7 480 264C480 277.3 469.3 288 456 288L408 288C394.7 288 384 277.3 384 264C384 250.7 394.7 240 408 240zM280 320L456 320C469.3 320 480 330.7 480 344C480 357.3 469.3 368 456 368L280 368C266.7 368 256 357.3 256 344C256 330.7 266.7 320 280 320zM280 400L456 400C469.3 400 480 410.7 480 424C480 437.3 469.3 448 456 448L280 448C266.7 448 256 437.3 256 424C256 410.7 266.7 400 280 400z" />
                    </svg>
                    <p>Tin Tức</p>
                </a>
            </div>
            <p>|</p>
            <div class="feature-bar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                    <path
                        d="M128 288C128 182 214 96 320 96C426 96 512 182 512 288C512 394 426 480 320 480C214 480 128 394 128 288zM304 196L304 200C275.2 200.3 252 223.7 252 252.5C252 278.2 270.5 300.1 295.9 304.3L337.6 311.3C343.6 312.3 348 317.5 348 323.6C348 330.5 342.4 336.1 335.5 336.1L280 336C269 336 260 345 260 356C260 367 269 376 280 376L304 376L304 380C304 391 313 400 324 400C335 400 344 391 344 380L344 375.3C369 371.2 388 349.6 388 323.5C388 297.8 369.5 275.9 344.1 271.7L302.4 264.7C296.4 263.7 292 258.5 292 252.4C292 245.5 297.6 239.9 304.5 239.9L352 239.9C363 239.9 372 230.9 372 219.9C372 208.9 363 199.9 352 199.9L344 199.9L344 195.9C344 184.9 335 175.9 324 175.9C313 175.9 304 184.9 304 195.9zM80 408L80 512C80 520.8 87.2 528 96 528L544 528C552.8 528 560 520.8 560 512L560 408C560 394.7 570.7 384 584 384C597.3 384 608 394.7 608 408L608 512C608 547.3 579.3 576 544 576L96 576C60.7 576 32 547.3 32 512L32 408C32 394.7 42.7 384 56 384C69.3 384 80 394.7 80 408z" />
                </svg>
                <p>Thu cũ đổi mới</p>
            </div>
            <p>|</p>
            <div class="feature-bar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                    <path
                        d="M333.4 66.9C329.2 65 324.7 64 320 64C315.3 64 310.8 65 306.6 66.9L118.3 146.8C96.3 156.1 79.9 177.8 80 204C80.5 303.2 121.3 484.7 293.6 567.2C310.3 575.2 329.7 575.2 346.4 567.2C518.8 484.7 559.6 303.2 560 204C560.1 177.8 543.7 156.1 521.7 146.8L333.4 66.9zM313.6 247.5L320 256L326.4 247.5C337.5 232.7 354.9 224 373.3 224C405.7 224 432 250.3 432 282.7L432 288C432 337.1 366.2 386.1 335.5 406.3C326 412.5 314 412.5 304.6 406.3C273.9 386.1 208.1 337 208.1 288L208.1 282.7C208.1 250.3 234.4 224 266.8 224C285.3 224 302.7 232.7 313.7 247.5z" />
                </svg>
                <p> Tra cứu bảo hành</p>
            </div>
        </div>
    </div>
</header>