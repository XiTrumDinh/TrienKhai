<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Tin Công Nghệ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="public/css/news.css">

</head>

<body>

    <?php include "navbar.php"; ?>

    <!-- HERO -->

    <section class="hero-news">

        <div class="container">

            <div class="hero-grid">

                <!-- BIG ARTICLE -->

                <div class="hero-main news-open"

                    data-title="AI đang thay đổi ngành công nghệ như thế nào?"

                    data-content='

                    <img class="article-cover"
                    src="https://images.unsplash.com/photo-1518770660439-4636190af475">

                    <div class="article-meta">

                        <span class="badge bg-primary">
                            AI
                        </span>

                        <span>
                            • 5 phút đọc
                        </span>

                        <span>
                            • Hôm nay
                        </span>

                    </div>

                    <p>
                        AI hiện đang trở thành trung tâm của mọi thiết bị công nghệ hiện đại.
                    </p>

                    '>

                    <img src="https://images.unsplash.com/photo-1518770660439-4636190af475">

                    <div class="hero-overlay">

                        <span class="hero-tag">
                            AI
                        </span>

                        <h1>
                            AI đang thay đổi ngành công nghệ như thế nào?
                        </h1>

                        <p>
                            Công nghệ AI đang bùng nổ trên smartphone, laptop và phần mềm.
                        </p>

                    </div>

                </div>

                <!-- SIDE -->

                <div class="hero-side">

                    <div class="side-news">

                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085">

                        <div>

                            <span>
                                Laptop
                            </span>

                            <h4>
                                Xu hướng laptop gaming năm 2026
                            </h4>

                        </div>

                    </div>

                    <div class="side-news">

                        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9">

                        <div>

                            <span>
                                Smartphone
                            </span>

                            <h4>
                                Smartphone AI đang phát triển mạnh
                            </h4>

                        </div>

                    </div>

                    <div class="side-news">

                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d">

                        <div>

                            <span>
                                Công nghệ
                            </span>

                            <h4>
                                Chip 2nm sẽ xuất hiện vào năm sau
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- NEWS GRID -->

    <section class="news-section">

        <div class="container">

            <div class="section-title">

                <h2>
                    Tin mới nhất
                </h2>

            </div>

            <div class="news-grid">

                <!-- CARD -->

                <div class="news-card">

                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085">

                    <div class="news-card-body">

                        <span>
                            Laptop
                        </span>

                        <h3>
                            GPU mới đang thay đổi gaming laptop
                        </h3>

                        <p>
                            AI optimization và DLSS đang tăng FPS đáng kể.
                        </p>

                    </div>

                </div>

                <!-- CARD -->

                <div class="news-card">

                    <img src="https://images.unsplash.com/photo-1517336714739-489689fd1ca8">

                    <div class="news-card-body">

                        <span>
                            Gaming
                        </span>

                        <h3>
                            Gaming handheld quay trở lại
                        </h3>

                        <p>
                            Steam Deck và ASUS ROG Ally đang cực hot.
                        </p>

                    </div>

                </div>

                <!-- CARD -->

                <div class="news-card">

                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3">

                    <div class="news-card-body">

                        <span>
                            AI
                        </span>

                        <h3>
                            AI chatbot sẽ thay đổi internet?
                        </h3>

                        <p>
                            Các công cụ AI đang thay đổi cách tìm kiếm thông tin.
                        </p>

                    </div>

                </div>

                <!-- CARD -->

                <div class="news-card">

                    <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5">

                    <div class="news-card-body">

                        <span>
                            Security
                        </span>

                        <h3>
                            An ninh mạng đang trở nên quan trọng hơn
                        </h3>

                        <p>
                            Hacker AI bắt đầu trở thành mối nguy mới.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- MODAL -->

    <div class="modal fade"
        id="newsModal"
        tabindex="-1">

        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <h3 class="modal-title"
                        id="modalTitle"></h3>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body article-modal-body">

                    <div id="modalArticleContent">

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- FLOATING BUTTON -->

    <button class="add-news-btn"
        data-bs-toggle="modal"
        data-bs-target="#addNewsModal">

        +

    </button>
    <!-- ADD NEWS MODAL -->

    <div class="modal fade"
        id="addNewsModal"
        tabindex="-1">

        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <h3 class="modal-title">
                        Thêm bài viết
                    </h3>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row g-4">

                        <!-- LEFT -->

                        <div class="col-lg-8">

                            <div class="mb-4">

                                <label class="form-label">
                                    Tiêu đề
                                </label>

                                <input type="text"
                                    class="form-control form-control-lg"
                                    placeholder="Nhập tiêu đề">

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    Mở bài
                                </label>

                                <textarea class="form-control"
                                    rows="4"></textarea>

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    Thân bài
                                </label>

                                <textarea class="form-control"
                                    rows="8"></textarea>

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    Kết bài
                                </label>

                                <textarea class="form-control"
                                    rows="4"></textarea>

                            </div>

                        </div>

                        <!-- RIGHT -->

                        <div class="col-lg-4">

                            <div class="mb-4">

                                <label class="form-label">
                                    Thể loại
                                </label>

                                <select class="form-select">

                                    <option>
                                        AI
                                    </option>

                                    <option>
                                        Smartphone
                                    </option>

                                    <option>
                                        Laptop
                                    </option>

                                    <option>
                                        Gaming
                                    </option>

                                    <option>
                                        Công nghệ mới
                                    </option>

                                </select>

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    Ảnh cover
                                </label>

                                <input type="text"
                                    class="form-control">

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    Gallery ảnh
                                </label>

                                <textarea class="form-control"
                                    rows="8"></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-light"
                        data-bs-dismiss="modal">

                        Hủy

                    </button>

                    <button class="btn btn-primary">

                        Đăng bài

                    </button>

                </div>

            </div>

        </div>

    </div>
    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="public/js/news.js"></script>

</body>

</html>