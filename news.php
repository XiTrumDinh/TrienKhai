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
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <!-- HERO -->
    <section class="hero-news">
        <div class="container">

            <div class="hero-grid">

                <?php if ($hero): ?>
                    <div class="hero-main news-open" data-title="<?= htmlspecialchars($hero['title'], ENT_QUOTES) ?>"
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
                        <div class="side-news news-open" data-title="<?= htmlspecialchars($news['title'], ENT_QUOTES) ?>"
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
                    <div class="news-card news-open" data-title="<?= htmlspecialchars($news['title'], ENT_QUOTES) ?>"
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

                <form action="Controller/save_news.php" method="POST" enctype="multipart/form-data">

                    <div class="modal-header">
                        <h3 class="modal-title">Thêm bài viết</h3>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row g-4">

                            <!-- LEFT -->
                            <div class="col-lg-8">

                                <div class="mb-4">
                                    <label>Tiêu đề</label>

                                    <input type="text" name="title" class="form-control" required>
                                </div>

                                <div class="mb-4">
                                    <label>Mở bài</label>

                                    <textarea name="excerpt" class="form-control" rows="4" required></textarea>
                                </div>

                                <div class="mb-2 d-flex justify-content-between align-items-center">
                                    <label>Nội dung</label>

                                    <input type="file" id="inlineImage" accept="image/*" style="display:none"
                                        onchange="insertUploadedImage(this)">

                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="document.getElementById('inlineImage').click()">
                                        Chèn ảnh
                                    </button>
                                </div>

                                <div class="mb-4">
                                    <textarea id="contentBox" name="content" class="form-control" rows="12"
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
                                    <div class="mb-4">
                                        <label>Ảnh cover</label>
                                        <input type="file" name="cover_file" id="coverFileInput" class="form-control"
                                            accept="image/*" required onchange="compressCoverImage(this)">
                                        <!-- THÊM DÒNG NÀY -->
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Hủy
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Đăng bài
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- FLOAT BUTTON -->
    <button class="add-news-btn" data-bs-toggle="modal" data-bs-target="#addNewsModal">
        +
    </button>

    <!-- NEWS DETAIL MODAL -->
    <div class="modal fade" id="newsModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h3 class="modal-title" id="modalTitle"></h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <p>
                        <small class="text-muted" id="modalAuthor"></small>
                    </p>

                    <hr>

                    <div id="modalArticleContent"></div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Đóng
                    </button>

                </div>

            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const newsItems = document.querySelectorAll(".news-open");
            const modalTitle = document.getElementById("modalTitle");
            const modalContent = document.getElementById("modalArticleContent");
            const modalAuthor = document.getElementById("modalAuthor");

            newsItems.forEach(item => {
                item.addEventListener("click", function () {
                    modalTitle.textContent = this.dataset.title;
                    modalAuthor.textContent = "Tác giả: " + this.dataset.author;

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

        // CODE ĐÃ ĐƯỢC SỬA: Upload ảnh lên host qua AJAX thay vì dùng FileReader cũ làm sập DB
        function insertUploadedImage(input) {
            const file = input.files[0];
            if (!file) return;

            // Tạo Form dữ liệu ảo để gửi file qua AJAX
            const formData = new FormData();
            formData.append('image', file);

            // Âm thầm gửi file lên file xử lý upload trên hosting (upload_ajax.php)
            // Lưu ý: Đảm bảo đường dẫn này đúng với vị trí file upload_ajax.php của cậu
            fetch('Controller/upload_ajax.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tạo thẻ img với link ảnh THẬT từ server trả về (Đã thêm class Bootstrap cho đẹp)
                        const imgTag = `\n<img src="${data.url}" class="img-fluid my-3" alt="article image">\n`;

                        const textarea = document.getElementById("contentBox");
                        const start = textarea.selectionStart;
                        const end = textarea.selectionEnd;

                        // Chèn thẻ <img> vào đúng vị trí con trỏ chuột trong ô viết bài
                        textarea.value =
                            textarea.value.substring(0, start) +
                            imgTag +
                            textarea.value.substring(end);

                        textarea.focus();

                        // Đặt con trỏ chuột nằm ngay sau thẻ ảnh vừa chèn
                        textarea.selectionStart = start + imgTag.length;
                        textarea.selectionEnd = start + imgTag.length;

                        // Reset ô chọn file để có thể chọn lại cùng 1 ảnh nếu muốn
                        input.value = '';
                    } else {
                        // Hiện thông báo nếu file php báo lỗi (ví dụ: file quá nặng, sai định dạng...)
                        alert("Lỗi upload: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Có lỗi xảy ra trong quá trình kết nối tới máy chủ để tải ảnh.");
                });
        }
        function insertUploadedImage(input) {
            const file = input.files[0];
            if (!file) return;

            // Nếu file là ảnh và nặng hơn 1.5MB, tiến hành nén tự động bằng Javascript
            if (file.type.startsWith('image/') && file.size > 1.5 * 1024 * 1024) {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function (event) {
                    const img = new Image();
                    img.src = event.target.result;
                    img.onload = function () {
                        // Tạo canvas để vẽ lại ảnh với kích thước/chất lượng thấp hơn
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;

                        // Nếu ảnh quá to (ví dụ hơn 1600px), tự động scale nhỏ lại cho nhẹ
                        const max_size = 1600;
                        if (width > height) {
                            if (width > max_size) { height *= max_size / width; width = max_size; }
                        } else {
                            if (height > max_size) { width *= max_size / height; height = max_size; }
                        }

                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        // Nén ảnh về định dạng jpeg với chất lượng 70% (0.7) -> Ảnh sẽ cực nhẹ
                        canvas.toBlob(function (blob) {
                            const compressedFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            // Gửi file đã nén lên server
                            ajaxUploadImage(compressedFile, input);
                        }, 'image/jpeg', 0.7);
                    };
                };
            } else {
                // Nếu ảnh nhỏ sẵn dưới 1.5MB thì gửi thẳng không cần nén
                ajaxUploadImage(file, input);
            }
        }

        // Hàm phụ trách gửi AJAX tách riêng ra cho code sạch sẽ
        function ajaxUploadImage(file, input) {
            const formData = new FormData();
            formData.append('image', file);

            fetch('Controller/upload_ajax.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const imgTag = `\n<img src="${data.url}" class="img-fluid my-3" alt="article image">\n`;
                        const textarea = document.getElementById("contentBox");
                        const start = textarea.selectionStart;
                        const end = textarea.selectionEnd;

                        textarea.value = textarea.value.substring(0, start) + imgTag + textarea.value.substring(end);
                        textarea.focus();
                        textarea.selectionStart = start + imgTag.length;
                        textarea.selectionEnd = start + imgTag.length;
                        input.value = '';
                    } else {
                        alert("Lỗi upload: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Có lỗi xảy ra trong quá trình kết nối tới máy chủ.");
                });
        }
        function compressCoverImage(input) {
            const file = input.files[0];
            if (!file) return;

            // Chỉ nén nếu file là ảnh và dung lượng lớn hơn 1.5MB (để tiết kiệm tài nguyên)
            if (file.type.startsWith('image/') && file.size > 1.5 * 1024 * 1024) {

                // Tạo hiệu ứng thông báo trực quan cho người dùng biết hệ thống đang xử lý
                const originalLabel = input.previousElementSibling;
                if (originalLabel) originalLabel.innerText = "Ảnh cover (Đang tối ưu dung lượng ảnh...)";

                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function (event) {
                    const img = new Image();
                    img.src = event.target.result;
                    img.onload = function () {
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;

                        // Giới hạn chiều rộng ảnh cover tối đa 1920px (chuẩn hiển thị website)
                        const max_size = 1920;
                        if (width > height) {
                            if (width > max_size) { height *= max_size / width; width = max_size; }
                        } else {
                            if (height > max_size) { width *= max_size / height; height = max_size; }
                        }

                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        // Nén ảnh về chất lượng 75%
                        canvas.toBlob(function (blob) {
                            const compressedFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });

                            // TIẾN HÀNH NHÉT NGƯỢC FILE ĐÃ NÉN VÀO Ô INPUT FILE
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(compressedFile);
                            input.files = dataTransfer.files;

                            // Khôi phục lại chữ hiển thị ban đầu
                            if (originalLabel) originalLabel.innerText = "Ảnh cover (Đã tối ưu thành công!)";
                        }, 'image/jpeg', 0.75);
                    };
                };
            }
        }
    </script>


</body>

</html>