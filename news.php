<?php
require_once "Database/Database.php";

$db = new Database();

$allNews = $db->select("
    SELECT news.*, users.fullname
    FROM news
    JOIN users ON news.author_id = users.id
    ORDER BY news.created_at DESC
");

$hero = $allNews[0] ?? null;
$sideNews = array_slice($allNews, 1, 3);
$cards = array_slice($allNews, 4);

function safeImg($img)
{
    return !empty($img)
        ? htmlspecialchars($img)
        : "public/uploads/default.jpg";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Công Nghệ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/news.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <!-- HERO -->
    <section class="hero-news">
        <div class="container">

            <div class="hero-grid">

                <?php if ($hero): ?>
                    <div class="hero-main news-open"
                        data-title="<?= htmlspecialchars($hero['title'], ENT_QUOTES) ?>"
                        data-content="<?= htmlspecialchars($hero['content'] ?? '', ENT_QUOTES) ?>"
                        data-author="<?= htmlspecialchars($hero['fullname'], ENT_QUOTES) ?>">

                        <img src="<?= safeImg($hero['cover_image']) ?>">

                        <div class="hero-overlay">
                            <span class="hero-tag">
                                <?= htmlspecialchars($hero['category']) ?>
                            </span>

                            <h1 class="hero-title">
                                <?= htmlspecialchars($hero['title']) ?>
                            </h1>

                            <p class="hero-excerpt">
                                <?= htmlspecialchars(mb_strimwidth($hero['excerpt'] ?? '', 0, 120, '...')) ?>

                            </p>

                            <small class="news-author">
                                Đăng bởi <?= htmlspecialchars($hero['fullname']) ?>
                            </small>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="hero-side">
                    <?php foreach ($sideNews as $news): ?>
                        <div class="side-news news-open"
                            data-title="<?= htmlspecialchars($news['title'], ENT_QUOTES) ?>"
                            data-content="<?= htmlspecialchars($news['content'] ?? '', ENT_QUOTES) ?>"
                            data-author="<?= htmlspecialchars($news['fullname'], ENT_QUOTES) ?>">

                            <img src="<?= safeImg($news['cover_image']) ?>">

                            <div>
                                <span><?= htmlspecialchars($news['category']) ?></span>
                                <h4><?= htmlspecialchars($news['title']) ?></h4>

                                <small class="news-author">
                                    <?= htmlspecialchars($news['fullname']) ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </div>
    </section>

    <!-- NEWS GRID -->
    <section class="news-section">
        <div class="container">

            <div class="section-title">
                <h2>Tin mới nhất</h2>
            </div>

            <div class="news-grid">

                <?php foreach ($cards as $news): ?>
                    <div class="news-card news-open"
                        data-title="<?= htmlspecialchars($news['title'], ENT_QUOTES) ?>"
                        data-content="<?= htmlspecialchars($news['content'] ?? '', ENT_QUOTES) ?>"
                        data-author="<?= htmlspecialchars($news['fullname'], ENT_QUOTES) ?>">

                        <img src="<?= safeImg($news['cover_image']) ?>">

                        <div class="news-card-body">
                            <span><?= htmlspecialchars($news['category']) ?></span>

                            <h3>
                                <?= htmlspecialchars($news['title']) ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars($news['excerpt']) ?>
                            </p>

                            <small class="news-author">
                                <?= htmlspecialchars($news['fullname']) ?>
                            </small>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </section>

    <!-- ADD NEWS MODAL -->
    <div class="modal fade" id="addNewsModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <form action="Controller/save_news.php"
                    method="POST"
                    enctype="multipart/form-data">

                    <div class="modal-header">
                        <h3 class="modal-title">Thêm bài viết</h3>

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row g-4">

                            <!-- LEFT -->
                            <div class="col-lg-8">

                                <div class="mb-4">
                                    <label>Tiêu đề</label>

                                    <input type="text"
                                        name="title"
                                        class="form-control"
                                        required>
                                </div>

                                <div class="mb-4">
                                    <label>Mở bài</label>

                                    <textarea name="excerpt"
                                        class="form-control"
                                        rows="4"
                                        required></textarea>
                                </div>

                                <div class="mb-2 d-flex justify-content-between align-items-center">
                                    <label>Nội dung</label>

                                    <input type="file"
                                        id="inlineImage"
                                        accept="image/*"
                                        style="display:none"
                                        onchange="insertUploadedImage(this)">

                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        onclick="document.getElementById('inlineImage').click()">
                                        Chèn ảnh
                                    </button>
                                </div>

                                <div class="mb-4">
                                    <textarea id="contentBox"
                                        name="content"
                                        class="form-control"
                                        rows="12"
                                        required></textarea>
                                </div>

                            </div>

                            <!-- RIGHT -->
                            <div class="col-lg-4">

                                <div class="mb-4">
                                    <label>Thể loại</label>

                                    <select name="category" class="form-select">
                                        <option>AI</option>
                                        <option>Smartphone</option>
                                        <option>Laptop</option>
                                        <option>Gaming</option>
                                        <option>Security</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label>Ảnh cover</label>

                                    <input type="file"
                                        name="cover_file"
                                        class="form-control"
                                        accept="image/*"
                                        required>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                            Hủy
                        </button>

                        <button type="submit"
                            class="btn btn-primary">
                            Đăng bài
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- FLOAT BUTTON -->
    <button class="add-news-btn"
        data-bs-toggle="modal"
        data-bs-target="#addNewsModal">
        +
    </button>

    <!-- NEWS DETAIL MODAL -->
    <div class="modal fade" id="newsModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h3 class="modal-title" id="modalTitle"></h3>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <p>
                        <small class="text-muted" id="modalAuthor"></small>
                    </p>

                    <hr>

                    <div id="modalArticleContent"></div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Đóng
                    </button>

                </div>

            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const newsItems = document.querySelectorAll(".news-open");

            const modalTitle =
                document.getElementById("modalTitle");

            const modalContent =
                document.getElementById("modalArticleContent");

            const modalAuthor =
                document.getElementById("modalAuthor");

            newsItems.forEach(item => {

                item.addEventListener("click", function() {

                    modalTitle.textContent =
                        this.dataset.title;

                    modalAuthor.textContent =
                        "Tác giả: " + this.dataset.author;

                    modalContent.innerHTML = `
                        <div class="article-content">
                            ${this.dataset.content}
                        </div>
                    `;

                    const modal = new bootstrap.Modal(
                        document.getElementById("newsModal")
                    );

                    modal.show();

                });

            });

        });

        function insertUploadedImage(input) {

            const file = input.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(e) {

                const textarea =
                    document.getElementById("contentBox");

                const imgTag = `
<img src="${e.target.result}">
`;

                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;

                textarea.value =
                    textarea.value.substring(0, start) +
                    imgTag +
                    textarea.value.substring(end);

                textarea.focus();
            };

            reader.readAsDataURL(file);
        }
    </script>

</body>

</html>