<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/TrienKhai/TrienKhai/public/css/profile.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="container py-5">

        <div class="profile-wrapper">

            <!-- COVER -->
            <div class="profile-cover">

                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475"
                    class="cover-image">

                <button class="change-cover-btn">
                    📷
                </button>

            </div>

            <!-- TOP INFO -->
            <div class="profile-top">

                <!-- LEFT -->
                <div class="profile-left">

                    <img src="public/img/avatar/avatar.jpg"
                        class="profile-avatar">

                    <div class="profile-user-info">

                        <div class="profile-name-row">

                            <h2>
                                <?= $_SESSION["user"] ?>
                            </h2>

                            <div class="profile-role-badge">

                                <?= strtoupper($_SESSION["role"] ?? "user") ?>

                            </div>

                        </div>

                        <p class="profile-desc">
                            Thành viên KPD • Yêu công nghệ • Thích gaming
                        </p>

                        <div class="profile-stats">

                            <div class="stat-box">

                                <strong>14</strong>

                                <span>Đơn hàng</span>

                            </div>

                            <div class="stat-box">

                                <strong>6</strong>

                                <span>Bài viết</span>

                            </div>

                            <div class="stat-box">

                                <strong>2025</strong>

                                <span>Tham gia</span>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="profile-actions">

                    <button class="edit-profile-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">

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
                            Thành viên của KPD từ năm 2025.
                            Đam mê công nghệ, gaming và phần cứng máy tính.
                        </p>

                    </div>

                    <div class="sidebar-card">

                        <h5>
                            🖥️ Sở thích
                        </h5>

                        <div class="interest-tags">

                            <span>AI</span>
                            <span>Gaming</span>
                            <span>Laptop</span>
                            <span>PC Build</span>

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
                                    <?= $_SESSION["user"] ?>
                                </span>

                            </div>

                            <div class="info-row">

                                <span class="info-label">
                                    📧 Email
                                </span>

                                <span class="info-value">
                                    user@gmail.com
                                </span>

                            </div>

                            <div class="info-row">

                                <span class="info-label">
                                    📱 Số điện thoại
                                </span>

                                <span class="info-value">
                                    0123 456 789
                                </span>

                            </div>

                            <div class="info-row">

                                <span class="info-label">
                                    📍 Địa chỉ
                                </span>

                                <span class="info-value">
                                    TP. Hồ Chí Minh
                                </span>

                            </div>

                            <div class="info-row">

                                <span class="info-label">
                                    📅 Ngày tham gia
                                </span>

                                <span class="info-value">
                                    01/01/2025
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- MODAL -->
    <div class="modal fade"
        id="editProfileModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h3 class="modal-title">
                        ✏️ Chỉnh sửa hồ sơ
                    </h3>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-4 text-center">

                        <img src="public/img/avatar/avatar.jpg"
                            class="edit-avatar-preview">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Tên tài khoản
                        </label>

                        <input type="text"
                            class="form-control"
                            value="<?= $_SESSION["user"] ?>">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                            class="form-control"
                            value="user@gmail.com">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Số điện thoại
                        </label>

                        <input type="text"
                            class="form-control"
                            value="0123 456 789">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Địa chỉ
                        </label>

                        <input type="text"
                            class="form-control"
                            value="TP. Hồ Chí Minh">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Ảnh đại diện
                        </label>

                        <input type="file"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Ảnh nền
                        </label>

                        <input type="file"
                            class="form-control">

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Hủy

                    </button>

                    <button class="btn btn-primary">

                        Lưu thay đổi

                    </button>

                </div>

            </div>

        </div>

    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>