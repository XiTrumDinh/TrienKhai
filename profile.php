<?php
session_start();

require_once "Database/Database.php";

$db = new Database();
$userId = $_SESSION["id"];

$stmt = $db->conn->prepare("
    SELECT * FROM users 
    WHERE id = ?
");

$stmt->bind_param("i", $userId);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();
$userId = $user["id"];

// Đếm đơn hàng
$orderStmt = $db->conn->prepare("
    SELECT COUNT(*) as total_orders
    FROM orders
    WHERE user_id = ?
");

$orderStmt->bind_param("i", $userId);

$orderStmt->execute();

$orderResult = $orderStmt->get_result();

$totalOrders = $orderResult->fetch_assoc()["total_orders"];
// Đếm bài viết
$postStmt = $db->conn->prepare("
    SELECT COUNT(*) as total_posts
    FROM news
    WHERE author_id = ?
");

$postStmt->bind_param("i", $userId);

$postStmt->execute();

$postResult = $postStmt->get_result();

$totalPosts = $postResult->fetch_assoc()["total_posts"];
// Avatar mặc định
$avatar = !empty($user["avatar"])
    ? $user["avatar"]
    : "public/img/avatar/avatar.jpg";

// Cover mặc định
$cover = !empty($user["cover"])
    ? $user["cover"]
    : "https://images.unsplash.com/photo-1518770660439-4636190af475";

$bio = !empty($user["bio"])
    ? $user["bio"]
    : "Chưa có giới thiệu.";

$interests = !empty($user["interests"])
    ? explode(",", $user["interests"])
    : ["Chưa có sở thích"];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/profile.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="container py-5">

        <div class="profile-wrapper">

            <!-- COVER -->
            <div class="profile-cover">

                <img src="<?= $cover ?>" class="cover-image">

                <button class="change-cover-btn">
                    📷
                </button>

            </div>

            <!-- TOP INFO -->
            <div class="profile-top">

                <!-- LEFT -->
                <div class="profile-left">

                    <img src="<?= $avatar ?>" class="profile-avatar">

                    <div class="profile-user-info">

                        <div class="profile-name-row">

                            <h2>
                                <?= $user["fullname"] ?>
                            </h2>

                            <div class="profile-role-badge">

                                <?= strtoupper($user["role"]) ?>

                            </div>

                        </div>

                        <div class="profile-stats">

                            <div class="stat-box">

                                <strong><?= $totalOrders ?></strong>

                                <span>Đơn hàng</span>

                            </div>

                            <div class="stat-box">

                                <strong><?= $totalPosts ?></strong>

                                <span>Bài viết</span>

                            </div>

                            <div class="stat-box">

                                <strong>
                                    <?= date("Y", strtotime($user["created_at"])) ?>
                                </strong>

                                <span>Tham gia</span>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="profile-actions">

                    <button class="edit-profile-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">

                        ✏️ Chỉnh sửa hồ sơ

                    </button>

                </div>

            </div>

            <!-- BODY -->
            <div class="profile-body">

                <!-- LEFT SIDEBAR -->
                <div class="profile-sidebar">

                    <div class="sidebar-card">

                        <h5>
                            📌 Giới thiệu
                        </h5>

                        <p>

                            <?= $bio ?>
                        </p>

                    </div>

                    <div class="sidebar-card">

                        <h5>
                            🖥️ Sở thích
                        </h5>

                        <div class="interest-tags">

                            <?php foreach ($interests as $interest): ?>

                                <span>
                                    <?= trim($interest) ?>
                                </span>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

                <!-- MAIN -->
                <div class="profile-main">

                    <div class="content-card">

                        <div class="content-header">

                            <h4>
                                Thông tin cá nhân
                            </h4>

                        </div>

                        <div class="info-list">

                            <div class="info-row">

                                <span class="info-label">
                                    👤 Tài khoản
                                </span>

                                <span class="info-value">
                                    <?= $user["username"] ?>
                                </span>

                            </div>

                            <div class="info-row">

                                <span class="info-label">
                                    🪪 Họ tên
                                </span>

                                <span class="info-value">
                                    <?= $user["fullname"] ?>
                                </span>

                            </div>

                            <div class="info-row">

                                <span class="info-label">
                                    📧 Email
                                </span>

                                <span class="info-value">
                                    <?= $user["email"] ?>
                                </span>

                            </div>

                            <div class="info-row">

                                <span class="info-label">
                                    📱 Số điện thoại
                                </span>

                                <span class="info-value">
                                    <?= $user["phone"] ?>
                                </span>

                            </div>

                            <div class="info-row">

                                <span class="info-label">
                                    📍 Địa chỉ
                                </span>

                                <span class="info-value">
                                    <?= $user["address"] ?>
                                </span>

                            </div>

                            <div class="info-row">

                                <span class="info-label">
                                    📅 Ngày tham gia
                                </span>

                                <span class="info-value">
                                    <?= date("d/m/Y", strtotime($user["created_at"])) ?>
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- MODAL -->
    <!-- MODAL -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">

                <form action="Controller/update_profile.php" method="POST" enctype="multipart/form-data">

                    <div class="modal-header">

                        <h3 class="modal-title">
                            ✏️ Chỉnh sửa hồ sơ
                        </h3>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <!-- AVATAR -->

                        <div class="text-center mb-4">

                            <img src="<?= $avatar ?>" class="edit-avatar-preview mb-3">

                        </div>

                        <!-- FULLNAME -->

                        <div class="mb-3">

                            <label class="form-label">
                                Họ tên
                            </label>

                            <input type="text" name="fullname" class="form-control" value="<?= $user["fullname"] ?>">

                        </div>

                        <!-- EMAIL -->

                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email" name="email" class="form-control" value="<?= $user["email"] ?>">

                        </div>

                        <!-- PHONE -->

                        <div class="mb-3">

                            <label class="form-label">
                                Số điện thoại
                            </label>

                            <input type="text" name="phone" class="form-control" value="<?= $user["phone"] ?>">

                        </div>

                        <!-- ADDRESS -->

                        <div class="mb-3">

                            <label class="form-label">
                                Địa chỉ
                            </label>

                            <input type="text" name="address" class="form-control" value="<?= $user["address"] ?>">

                        </div>

                        <!-- BIO -->

                        <div class="mb-3">

                            <label class="form-label">
                                Giới thiệu
                            </label>

                            <textarea name="bio" class="form-control" rows="4"><?= $user["bio"] ?></textarea>

                        </div>

                        <!-- INTERESTS -->

                        <div class="mb-3">

                            <label class="form-label">
                                Sở thích
                            </label>

                            <input type="text" name="interests" class="form-control" value="<?= $user["interests"] ?>"
                                placeholder="VD: AI,Gaming,Laptop">

                        </div>

                        <!-- AVATAR -->

                        <div class="mb-3">
                            <label class="form-label" id="avatarLabel">Ảnh đại diện</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*"
                                onchange="compressProfileImage(this, 'avatar')">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" id="coverLabel">Ảnh nền</label>
                            <input type="file" name="cover" class="form-control" accept="image/*"
                                onchange="compressProfileImage(this, 'cover')">
                        </div>

                        <script>
                            function compressProfileImage(input, type) {
                                const file = input.files[0];
                                if (!file) return;

                                const labelElement = document.getElementById(type + 'Label');

                                // Nếu ảnh lớn hơn 1.5MB thì tiến hành nén ngầm trước khi submit form
                                if (file.type.startsWith('image/') && file.size > 1.5 * 1024 * 1024) {
                                    if (labelElement) labelElement.innerText = (type === 'avatar' ? 'Ảnh đại diện' : 'Ảnh nền') + " (Đang tối ưu dung lượng...)";

                                    const reader = new FileReader();
                                    reader.readAsDataURL(file);
                                    reader.onload = function (event) {
                                        const img = new Image();
                                        img.src = event.target.result;
                                        img.onload = function () {
                                            const canvas = document.createElement('canvas');
                                            let width = img.width;
                                            let height = img.height;

                                            // Giới hạn chiều rộng tối đa (Avatar: 800px, Cover: 1920px FullHD)
                                            const max_size = (type === 'avatar') ? 800 : 1920;
                                            if (width > height) {
                                                if (width > max_size) { height *= max_size / width; width = max_size; }
                                            } else {
                                                if (height > max_size) { width *= max_size / height; height = max_size; }
                                            }

                                            canvas.width = width;
                                            canvas.height = height;
                                            const ctx = canvas.getContext('2d');
                                            ctx.drawImage(img, 0, 0, width, height);

                                            // Nén chất lượng xuống 75% dạng JPEG để giảm dung lượng tối đa
                                            canvas.toBlob(function (blob) {
                                                const compressedFile = new File([blob], file.name.replace(/\.[^/.]+$/, "") + ".jpg", {
                                                    type: 'image/jpeg',
                                                    lastModified: Date.now()
                                                });

                                                // Thay thế file nặng bằng file đã nén siêu nhẹ vào input file
                                                const dataTransfer = new DataTransfer();
                                                dataTransfer.items.add(compressedFile);
                                                input.files = dataTransfer.files;

                                                if (labelElement) labelElement.innerText = (type === 'avatar' ? 'Ảnh đại diện' : 'Ảnh nền') + " (Đã tối ưu thành công!)";
                                            }, 'image/jpeg', 0.75);
                                        };
                                    };
                                }
                            }
                        </script>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">

                            Hủy

                        </button>

                        <button class="btn btn-primary" type="submit">

                            💾 Lưu thay đổi

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Thêm thuộc tính onchange vào thẻ input của cậu -->
    <input type="file" name="avatar" class="form-control" accept="image/*" onchange="compressImage(this)">

  
</body>

</html>