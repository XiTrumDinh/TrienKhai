<?php
session_start();
require_once "Database/Database.php";
$type = $_GET['type'] ?? 'gioithieu';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $user = $db->select($sql, "ss", [$username, $password]);

    if (!empty($user)) {
        $_SESSION["user"] = $user[0]["username"];
        header("Location: index.php");
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Kipeeda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/faq.css">

</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="faq-container">
        <div class="faq-sidebar">

            <!-- MOBILE (accordion) -->
            <div class="faq-mobile d-md-none">

                <div class="faq-item <?= in_array($type, ['gioithieu', 'tuyendung', 'lienhe']) ? 'active' : '' ?>">
                    <div class="faq-title" onclick="toggleFaq(this)">
                        Về KIPEEDA <span>+</span>
                    </div>
                    <ul class="faq-list" style="<?= in_array($type, ['gioithieu', 'tuyendung', 'lienhe']) ? 'display:block' : '' ?>">
                        <li><a href="faq.php?type=gioithieu" class="<?= $type == 'gioithieu' ? 'active' : '' ?>">Giới thiệu</a></li>
                        <li><a href="faq.php?type=tuyendung" class="<?= $type == 'tuyendung' ? 'active' : '' ?>">Tuyển dụng</a></li>
                        <li><a href="faq.php?type=lienhe" class="<?= $type == 'lienhe' ? 'active' : '' ?>">Liên hệ</a></li>
                    </ul>
                </div>

                <div class="faq-item <?= in_array($type, ['baohanh', 'giaohang', 'baomat', 'tragop']) ? 'active' : '' ?>">
                    <div class="faq-title" onclick="toggleFaq(this)">
                        Chính sách <span>+</span>
                    </div>
                    <ul class="faq-list" style="<?= in_array($type, ['baohanh', 'giaohang', 'baomat', 'tragop']) ? 'display:block' : '' ?>">
                        <li><a href="faq.php?type=baohanh" class="<?= $type == 'baohanh' ? 'active' : '' ?>">Bảo hành</a></li>
                        <li><a href="faq.php?type=giaohang" class="<?= $type == 'giaohang' ? 'active' : '' ?>">Giao hàng</a></li>
                        <li><a href="faq.php?type=baomat" class="<?= $type == 'baomat' ? 'active' : '' ?>">Bảo mật</a></li>
                        <li><a href="faq.php?type=tragop" class="<?= $type == 'tragop' ? 'active' : '' ?>">Trả góp</a></li>
                    </ul>
                </div>
                <div class="faq-item <?= in_array($type, ['cuahang', 'muahang', 'thanhtoan', 'tragop_hd', 'baohanh_hd', 'buildpc']) ? 'active' : '' ?>">
                    <div class="faq-title" onclick="toggleFaq(this)">
                        Thông tin <span>+</span>
                    </div>

                    <ul class="faq-list" style="<?= in_array($type, ['cuahang', 'muahang', 'thanhtoan', 'tragop_hd', 'baohanh_hd', 'buildpc']) ? 'display:block' : '' ?>">

                        <li>
                            <a href="faq.php?type=cuahang" class="<?= $type == 'cuahang' ? 'active' : '' ?>">
                                Hệ thống cửa hàng
                            </a>
                        </li>

                        <li>
                            <a href="faq.php?type=muahang" class="<?= $type == 'muahang' ? 'active' : '' ?>">
                                Hướng dẫn mua hàng
                            </a>
                        </li>

                        <li>
                            <a href="faq.php?type=thanhtoan" class="<?= $type == 'thanhtoan' ? 'active' : '' ?>">
                                Hướng dẫn thanh toán
                            </a>
                        </li>

                        <li>
                            <a href="faq.php?type=tragop_hd" class="<?= $type == 'tragop_hd' ? 'active' : '' ?>">
                                Hướng dẫn trả góp
                            </a>
                        </li>

                        <li>
                            <a href="faq.php?type=baohanh_hd" class="<?= $type == 'baohanh_hd' ? 'active' : '' ?>">
                                Hướng dẫn bảo hành
                            </a>
                        </li>

                        <li>
                            <a href="faq.php?type=buildpc" class="<?= $type == 'buildpc' ? 'active' : '' ?>">
                                Build PC
                            </a>
                        </li>

                    </ul>
                </div>

            </div>

            <!-- DESKTOP -->
            <div class="faq-desktop d-none d-md-block">

                <h5>Về KIPEEDA</h5>
                <ul>
                    <li><a href="faq.php?type=gioithieu" class="<?= $type == 'gioithieu' ? 'active' : '' ?>">Giới thiệu</a></li>
                    <li><a href="faq.php?type=tuyendung" class="<?= $type == 'tuyendung' ? 'active' : '' ?>">Tuyển dụng</a></li>
                    <li><a href="faq.php?type=lienhe" class="<?= $type == 'lienhe' ? 'active' : '' ?>">Liên hệ</a></li>
                </ul>

                <h5 class="mt-3">Chính sách</h5>
                <ul>
                    <li><a href="faq.php?type=baohanh" class="<?= $type == 'baohanh' ? 'active' : '' ?>">Bảo hành</a></li>
                    <li><a href="faq.php?type=giaohang" class="<?= $type == 'giaohang' ? 'active' : '' ?>">Giao hàng</a></li>
                    <li><a href="faq.php?type=baomat" class="<?= $type == 'baomat' ? 'active' : '' ?>">Bảo mật</a></li>
                    <li><a href="faq.php?type=tragop" class="<?= $type == 'tragop' ? 'active' : '' ?>">Trả góp</a></li>
                </ul>

                <h5 class="mt-3">Thông tin</h5>
                <ul>
                    <li><a href="faq.php?type=cuahang" class="<?= $type == 'cuahang' ? 'active' : '' ?>">Cửa hàng</a></li>
                    <li><a href="faq.php?type=muahang" class="<?= $type == 'muahang' ? 'active' : '' ?>">Mua hàng</a></li>
                    <li><a href="faq.php?type=thanhtoan" class="<?= $type == 'thanhtoan' ? 'active' : '' ?>">Thanh toán</a></li>
                    <li><a href="faq.php?type=buildpc" class="<?= $type == 'buildpc' ? 'active' : '' ?>">Build PC</a></li>
                </ul>

            </div>

        </div>




        <!-- CONTENT -->
        <div class="faq-content">

            <?php
            $title = '';
            $content = '';

            switch ($type) {

                case 'gioithieu':
                    $title = "Giới thiệu";
                    $content = "
<p>KIPEEDA là nền tảng thương mại điện tử chuyên cung cấp các sản phẩm công nghệ như laptop, máy tính để bàn (PC) và linh kiện máy tính chính hãng. Được xây dựng với mục tiêu mang đến trải nghiệm mua sắm đơn giản, nhanh chóng và đáng tin cậy, KIPEEDA hướng tới việc trở thành điểm đến quen thuộc cho tất cả những ai đam mê công nghệ.</p>

<p>Trong thời đại công nghệ phát triển mạnh mẽ, nhu cầu sử dụng các thiết bị như laptop và PC ngày càng tăng cao, không chỉ phục vụ cho học tập và làm việc mà còn cho giải trí, sáng tạo nội dung và chơi game. Hiểu được điều đó, KIPEEDA mang đến đa dạng sản phẩm từ nhiều thương hiệu uy tín, đáp ứng mọi nhu cầu từ cơ bản đến nâng cao.</p>

<p>Tại KIPEEDA, khách hàng có thể dễ dàng tìm kiếm các dòng laptop phù hợp cho từng mục đích sử dụng như học sinh, sinh viên, dân văn phòng hay game thủ chuyên nghiệp. Các sản phẩm đều được chọn lọc kỹ lưỡng với cấu hình đa dạng, giá cả hợp lý và thông tin minh bạch.</p>

<p>Bên cạnh đó, KIPEEDA còn nổi bật với dịch vụ build PC theo yêu cầu. Người dùng có thể tự do lựa chọn linh kiện như CPU, RAM, ổ cứng, card đồ họa, mainboard và nguồn để xây dựng một bộ máy tính phù hợp với nhu cầu cá nhân.</p>

<p>Không chỉ cung cấp sản phẩm, KIPEEDA còn mang đến trải nghiệm mua sắm tối ưu với giao diện thân thiện, dễ sử dụng. Người dùng có thể nhanh chóng tìm kiếm sản phẩm, so sánh giá và xem thông tin chi tiết chỉ với vài thao tác đơn giản.</p>

<p>Mỗi sản phẩm trên KIPEEDA đều được hiển thị đầy đủ thông tin về cấu hình, tính năng, giá bán và hình ảnh thực tế. Điều này giúp khách hàng có cái nhìn trực quan và đưa ra quyết định chính xác hơn trước khi mua hàng.</p>

<p>Ngoài ra, KIPEEDA còn cung cấp nhiều chính sách hỗ trợ khách hàng như bảo hành rõ ràng, giao hàng nhanh chóng và hỗ trợ đổi trả linh hoạt. Đội ngũ tư vấn luôn sẵn sàng hỗ trợ để giúp khách hàng lựa chọn sản phẩm phù hợp nhất.</p>

<p>Hệ thống quản lý đơn hàng của KIPEEDA cũng được tối ưu hóa để người dùng có thể theo dõi trạng thái đơn hàng một cách dễ dàng và minh bạch.</p>

<p>KIPEEDA không chỉ là nơi mua sắm mà còn là nơi chia sẻ kiến thức công nghệ. Người dùng có thể tham khảo các hướng dẫn build PC, chọn linh kiện và sử dụng thiết bị một cách hiệu quả nhất.</p>

<p>Với định hướng phát triển lâu dài, KIPEEDA luôn không ngừng cải thiện chất lượng dịch vụ và mở rộng danh mục sản phẩm nhằm đáp ứng tốt hơn nhu cầu của khách hàng.</p>

<p><strong>Hãy để KIPEEDA đồng hành cùng bạn trên hành trình khám phá và chinh phục thế giới công nghệ.</strong></p>
";
                    break;

                case 'lienhe':
                    $title = "Liên hệ";
                    $content = "
<p>Nếu bạn có bất kỳ câu hỏi, thắc mắc hoặc cần hỗ trợ về sản phẩm và dịch vụ, KIPEEDA luôn sẵn sàng đồng hành và hỗ trợ bạn một cách nhanh chóng và tận tình.</p>

<p>Đội ngũ của chúng tôi cam kết mang đến trải nghiệm tốt nhất cho khách hàng trong suốt quá trình mua sắm và sử dụng sản phẩm.</p>

<h5>Thông tin liên hệ</h5>

<ul>
    <li><strong>Địa chỉ:</strong> Dĩ An, Bình Dương</li>
    <li><strong>Hotline:</strong> 0394 408 287</li>
    <li><strong>Email:</strong> support@kipeeda.com</li>
    <li><strong>Thời gian làm việc:</strong> 08:00 - 21:00 (Tất cả các ngày trong tuần)</li>
</ul>

<h5>Hỗ trợ khách hàng</h5>

<p>Chúng tôi hỗ trợ tư vấn về:</p>

<ul>
    <li>Lựa chọn laptop, PC phù hợp nhu cầu</li>
    <li>Tư vấn build PC theo ngân sách</li>
    <li>Hỗ trợ kỹ thuật và bảo hành sản phẩm</li>
    <li>Giải đáp thắc mắc về đơn hàng và thanh toán</li>
</ul>

<p>Bạn có thể liên hệ với KIPEEDA qua hotline, email hoặc đến trực tiếp cửa hàng để được hỗ trợ nhanh nhất.</p>

<p><strong>KIPEEDA luôn sẵn sàng lắng nghe và phục vụ bạn!</strong></p>
";
                    break;

                case 'tuyendung':
                    $title = "Tuyển dụng";
                    $content = "<p>KIPEEDA luôn chào đón những bạn trẻ năng động, đam mê công nghệ và mong muốn phát triển bản thân trong môi trường chuyên nghiệp. Chúng tôi tin rằng con người là yếu tố quan trọng nhất để xây dựng và phát triển một hệ thống bền vững.</p>

<p>Tại KIPEEDA, bạn sẽ có cơ hội làm việc trong môi trường thân thiện, sáng tạo và luôn khuyến khích sự đổi mới. Chúng tôi đề cao tinh thần học hỏi, chủ động và sẵn sàng hỗ trợ lẫn nhau để cùng phát triển.</p>

<p>Hiện tại, KIPEEDA đang tìm kiếm ứng viên cho các vị trí như:</p>

<ul>
    <li>Nhân viên bán hàng / tư vấn sản phẩm</li>
    <li>Nhân viên kỹ thuật (build PC, lắp ráp, cài đặt)</li>
    <li>Nhân viên marketing (content, quảng cáo, social media)</li>
    <li>Nhân viên quản trị website</li>
</ul>

<p>Khi trở thành một phần của KIPEEDA, bạn sẽ nhận được:</p>

<ul>
    <li>Mức thu nhập cạnh tranh, phù hợp với năng lực</li>
    <li>Môi trường làm việc trẻ trung, năng động</li>
    <li>Cơ hội học hỏi và phát triển kỹ năng chuyên môn</li>
    <li>Được tiếp cận với các sản phẩm công nghệ mới nhất</li>
</ul>

<p>Chúng tôi không chỉ tìm kiếm nhân sự, mà còn tìm kiếm những người đồng hành lâu dài. Nếu bạn yêu thích công nghệ và mong muốn phát triển trong lĩnh vực này, KIPEEDA chính là nơi dành cho bạn.</p>

<p><strong>Ứng tuyển ngay hôm nay để trở thành một phần của KIPEEDA!</strong></p>
";
                    break;

                case 'baohanh':
                    $title = "Chính sách bảo hành";
                    $content = "
<p>KIPEEDA cam kết cung cấp các sản phẩm chính hãng, chất lượng cao và đi kèm chính sách bảo hành rõ ràng nhằm đảm bảo quyền lợi tối đa cho khách hàng.</p>

<h5>1. Thời gian bảo hành</h5>
<ul>
    <li>Các sản phẩm laptop, PC và linh kiện được bảo hành từ 12 - 36 tháng tùy theo từng loại sản phẩm và hãng sản xuất.</li>
    <li>Thời gian bảo hành được tính từ ngày mua hàng ghi trên hóa đơn.</li>
</ul>

<h5>2. Điều kiện được bảo hành</h5>
<ul>
    <li>Sản phẩm còn trong thời hạn bảo hành.</li>
    <li>Có hóa đơn mua hàng hoặc thông tin đơn hàng tại KIPEEDA.</li>
    <li>Lỗi phát sinh do nhà sản xuất (lỗi kỹ thuật, phần cứng).</li>
</ul>

<h5>3. Trường hợp không được bảo hành</h5>
<ul>
    <li>Sản phẩm bị rơi vỡ, va đập mạnh hoặc vào nước.</li>
    <li>Sản phẩm bị can thiệp, sửa chữa bởi bên thứ ba không thuộc KIPEEDA.</li>
    <li>Hư hỏng do sử dụng sai cách hoặc do người dùng gây ra.</li>
</ul>

<h5>4. Quy trình bảo hành</h5>
<ul>
    <li>Khách hàng mang sản phẩm đến cửa hàng hoặc gửi về trung tâm bảo hành của KIPEEDA.</li>
    <li>Nhân viên kỹ thuật sẽ kiểm tra và xác định lỗi.</li>
    <li>Tiến hành sửa chữa hoặc thay thế theo chính sách bảo hành.</li>
</ul>

<h5>5. Thời gian xử lý</h5>
<ul>
    <li>Thời gian xử lý bảo hành từ 3 - 7 ngày làm việc tùy vào mức độ hư hỏng.</li>
    <li>Trường hợp cần gửi hãng, thời gian có thể kéo dài hơn.</li>
</ul>

<p><strong>KIPEEDA luôn nỗ lực mang đến dịch vụ hậu mãi tốt nhất để khách hàng yên tâm khi mua sắm.</strong></p>
";
                    break;

                case 'giaohang':
                    $title = "Chính sách giao hàng";
                    $content = "

<p>KIPEEDA cung cấp dịch vụ giao hàng nhanh chóng, an toàn và tiện lợi trên toàn quốc nhằm mang đến trải nghiệm mua sắm tốt nhất cho khách hàng.</p>

<h5>1. Phạm vi giao hàng</h5>
<ul>
    <li>Giao hàng toàn quốc thông qua các đơn vị vận chuyển uy tín.</li>
    <li>Hỗ trợ giao nhanh trong khu vực nội thành (tùy khu vực).</li>
</ul>

<h5>2. Thời gian giao hàng</h5>
<ul>
    <li>Khu vực nội thành: từ 1 - 2 ngày làm việc.</li>
    <li>Khu vực ngoại thành và tỉnh: từ 2 - 5 ngày làm việc.</li>
    <li>Thời gian có thể thay đổi tùy theo điều kiện thời tiết hoặc đơn vị vận chuyển.</li>
</ul>

<h5>3. Phí giao hàng</h5>
<ul>
    <li>Miễn phí giao hàng cho đơn hàng đạt giá trị theo chương trình khuyến mãi.</li>
    <li>Đối với các đơn hàng khác, phí vận chuyển sẽ được tính theo khu vực và trọng lượng sản phẩm.</li>
</ul>

<h5>4. Kiểm tra hàng khi nhận</h5>
<ul>
    <li>Khách hàng được kiểm tra sản phẩm trước khi thanh toán.</li>
    <li>Nếu phát hiện lỗi hoặc sai sản phẩm, khách hàng có thể từ chối nhận hàng.</li>
</ul>

<h5>5. Trách nhiệm giao nhận</h5>
<ul>
    <li>KIPEEDA đảm bảo đóng gói sản phẩm cẩn thận trước khi giao.</li>
    <li>Trong trường hợp hàng bị hư hỏng trong quá trình vận chuyển, chúng tôi sẽ hỗ trợ đổi trả theo chính sách.</li>
</ul>

<p><strong>KIPEEDA luôn nỗ lực giao hàng nhanh chóng và đảm bảo sản phẩm đến tay khách hàng trong tình trạng tốt nhất.</strong></p>
";
                    break;

                case 'baomat':
                    $title = "Chính sách bảo mật";
                    $content = "
<p>KIPEEDA cam kết bảo mật thông tin cá nhân của khách hàng và đảm bảo quyền riêng tư trong quá trình sử dụng dịch vụ. Chúng tôi hiểu rằng thông tin cá nhân là tài sản quan trọng và luôn được bảo vệ bằng các biện pháp an toàn.</p>

<h5>1. Mục đích thu thập thông tin</h5>
<ul>
    <li>Hỗ trợ xử lý đơn hàng và giao hàng đến khách hàng.</li>
    <li>Cung cấp thông tin về sản phẩm, dịch vụ và chương trình khuyến mãi.</li>
    <li>Nâng cao chất lượng dịch vụ và trải nghiệm người dùng.</li>
</ul>

<h5>2. Phạm vi thu thập thông tin</h5>
<ul>
    <li>Họ và tên</li>
    <li>Số điện thoại</li>
    <li>Email</li>
    <li>Địa chỉ giao hàng</li>
</ul>

<h5>3. Phạm vi sử dụng thông tin</h5>
<ul>
    <li>Thông tin chỉ được sử dụng nội bộ trong KIPEEDA.</li>
    <li>Không chia sẻ cho bên thứ ba nếu không có sự đồng ý của khách hàng, trừ khi có yêu cầu từ cơ quan pháp luật.</li>
</ul>

<h5>4. Bảo mật thông tin</h5>
<ul>
    <li>Áp dụng các biện pháp kỹ thuật để bảo vệ dữ liệu khỏi truy cập trái phép.</li>
    <li>Thông tin thanh toán được mã hóa và bảo mật.</li>
</ul>

<h5>5. Quyền của khách hàng</h5>
<ul>
    <li>Yêu cầu kiểm tra, cập nhật hoặc xóa thông tin cá nhân.</li>
    <li>Từ chối nhận thông tin quảng cáo bất kỳ lúc nào.</li>
</ul>

<p><strong>KIPEEDA cam kết bảo vệ thông tin của bạn một cách an toàn và minh bạch.</strong></p>
";
                    break;

                case 'tragop':
                    $title = "Chính sách trả góp";
                    $content = "

<p>KIPEEDA hỗ trợ khách hàng mua sắm sản phẩm công nghệ với hình thức trả góp linh hoạt, giúp bạn dễ dàng sở hữu thiết bị mong muốn mà không cần thanh toán toàn bộ chi phí ngay từ đầu.</p>

<h5>1. Hình thức trả góp</h5>
<ul>
    <li>Trả góp qua thẻ tín dụng (0% lãi suất).</li>
    <li>Trả góp qua công ty tài chính (duyệt hồ sơ nhanh chóng).</li>
</ul>

<h5>2. Điều kiện áp dụng</h5>
<ul>
    <li>Công dân từ 18 tuổi trở lên.</li>
    <li>Có CMND/CCCD hợp lệ.</li>
    <li>Có thẻ tín dụng hoặc hồ sơ cá nhân (đối với trả góp qua tài chính).</li>
</ul>

<h5>3. Lợi ích khi trả góp</h5>
<ul>
    <li>Không cần trả toàn bộ số tiền một lần.</li>
    <li>Lãi suất 0% (áp dụng với thẻ tín dụng).</li>
    <li>Thủ tục đơn giản, duyệt nhanh.</li>
</ul>

<h5>4. Quy trình trả góp</h5>
<ul>
    <li>Chọn sản phẩm và hình thức trả góp.</li>
    <li>Điền thông tin và gửi yêu cầu.</li>
    <li>Xác nhận hồ sơ và duyệt đơn.</li>
    <li>Nhận sản phẩm và thanh toán theo kỳ hạn.</li>
</ul>

<h5>5. Lưu ý</h5>
<ul>
    <li>Phí chuyển đổi trả góp có thể áp dụng tùy ngân hàng.</li>
    <li>Khách hàng cần thanh toán đúng hạn để tránh phí phát sinh.</li>
</ul>

<p><strong>KIPEEDA giúp bạn tiếp cận công nghệ dễ dàng hơn với hình thức thanh toán linh hoạt.</strong></p>
";
                    break;
                case 'cuahang':
                    $title = "Hệ thống cửa hàng";
                    $content = "
   <p>KIPEEDA hiện đang có hệ thống cửa hàng tại khu vực Bình Dương và TP. Thủ Đức, giúp khách hàng dễ dàng đến trải nghiệm sản phẩm và nhận hỗ trợ trực tiếp.</p>

<h5>1. Chi nhánh Thủ Đức</h5>
<ul>
    <li><strong>Địa chỉ:</strong> Linh Trung, TP. Thủ Đức, TP.HCM</li>
    <li><strong>Hotline:</strong> 0394 408 287</li>
    <li><strong>Giờ mở cửa:</strong> 08:00 - 21:00</li>
</ul>

<h5>2. Chi nhánh Dĩ An - Bình Dương</h5>
<ul>
    <li><strong>Địa chỉ:</strong> Dĩ An, Bình Dương</li>
    <li><strong>Hotline:</strong> 0349 869 563</li>
    <li><strong>Giờ mở cửa:</strong> 08:00 - 21:00</li>
</ul>

<h5>3. Chi nhánh Thủ Dầu Một</h5>
<ul>
    <li><strong>Địa chỉ:</strong> Thủ Dầu Một, Bình Dương</li>
    <li><strong>Hotline:</strong> 0357 824 279</li>
    <li><strong>Giờ mở cửa:</strong> 08:00 - 21:00</li>
</ul>

<p>Khách hàng có thể đến trực tiếp cửa hàng để trải nghiệm sản phẩm, nhận tư vấn build PC hoặc hỗ trợ kỹ thuật nhanh chóng.</p>

<p><strong>KIPEEDA luôn sẵn sàng phục vụ bạn tại cửa hàng gần nhất!</strong></p>
";
                    break;

                case 'muahang':
                    $title = "Hướng dẫn mua hàng";

                    $content = "


<p>KIPEEDA mang đến quy trình mua sắm đơn giản và nhanh chóng, giúp khách hàng dễ dàng lựa chọn và sở hữu sản phẩm mong muốn chỉ với vài bước cơ bản.</p>

<h5>1. Tìm kiếm sản phẩm</h5>
<ul>
    <li>Sử dụng thanh tìm kiếm để nhập tên sản phẩm cần mua.</li>
    <li>Hoặc duyệt sản phẩm theo danh mục như Laptop, PC, Linh kiện.</li>
</ul>

<h5>2. Xem chi tiết sản phẩm</h5>
<ul>
    <li>Nhấn vào sản phẩm để xem thông tin chi tiết.</li>
    <li>Kiểm tra cấu hình, giá bán và hình ảnh sản phẩm.</li>
</ul>

<h5>3. Thêm vào giỏ hàng</h5>
<ul>
    <li>Chọn số lượng sản phẩm.</li>
    <li>Nhấn nút <strong>Thêm vào giỏ hàng</strong>.</li>
</ul>

<h5>4. Thanh toán</h5>
<ul>
    <li>Truy cập vào giỏ hàng.</li>
    <li>Kiểm tra lại sản phẩm và nhấn <strong>Thanh toán</strong>.</li>
    <li>Nhập thông tin nhận hàng và chọn phương thức thanh toán.</li>
</ul>

<h5>5. Xác nhận đơn hàng</h5>
<ul>
    <li>Đơn hàng sẽ được xác nhận qua điện thoại hoặc email.</li>
    <li>KIPEEDA tiến hành xử lý và giao hàng.</li>
</ul>

<h5>6. Nhận hàng</h5>
<ul>
    <li>Kiểm tra sản phẩm khi nhận.</li>
    <li>Thanh toán (nếu chọn COD).</li>
</ul>

<p><strong>Chỉ với vài bước đơn giản, bạn đã có thể sở hữu sản phẩm công nghệ mong muốn tại KIPEEDA.</strong></p>
";
                    break;

                case 'thanhtoan':
                    $title = "Hướng dẫn thanh toán";
                    $content = "


<p>KIPEEDA hỗ trợ nhiều phương thức thanh toán linh hoạt, giúp khách hàng dễ dàng hoàn tất đơn hàng một cách nhanh chóng và thuận tiện.</p>

<h5>1. Thanh toán khi nhận hàng (COD)</h5>
<ul>
    <li>Khách hàng thanh toán trực tiếp cho nhân viên giao hàng.</li>
    <li>Áp dụng trên toàn quốc.</li>
</ul>

<h5>2. Thanh toán chuyển khoản</h5>
<ul>
    <li>Khách hàng chuyển khoản qua tài khoản ngân hàng của KIPEEDA.</li>
    <li>Thông tin tài khoản sẽ được cung cấp khi đặt hàng.</li>
</ul>

<h5>3. Thanh toán qua thẻ</h5>
<ul>
    <li>Hỗ trợ thanh toán qua thẻ ATM nội địa.</li>
    <li>Hỗ trợ thẻ tín dụng (Visa, Mastercard).</li>
</ul>

<h5>4. Thanh toán trả góp</h5>
<ul>
    <li>Áp dụng cho các sản phẩm có hỗ trợ trả góp.</li>
    <li>Khách hàng có thể chọn trả góp qua thẻ tín dụng hoặc công ty tài chính.</li>
</ul>

<h5>5. Lưu ý khi thanh toán</h5>
<ul>
    <li>Kiểm tra kỹ thông tin đơn hàng trước khi thanh toán.</li>
    <li>Giữ lại hóa đơn hoặc biên lai giao dịch để đối chiếu khi cần.</li>
    <li>Không cung cấp thông tin thanh toán cho bên thứ ba.</li>
</ul>

<p><strong>KIPEEDA cam kết mang đến trải nghiệm thanh toán an toàn, nhanh chóng và tiện lợi cho khách hàng.</strong></p>
";
                    break;

                case 'tragop_hd':
                    $title = "Hướng dẫn trả góp";
                    $content = "


<p>KIPEEDA hỗ trợ khách hàng mua sản phẩm bằng hình thức trả góp đơn giản, nhanh chóng. Dưới đây là các bước để bạn thực hiện đăng ký trả góp.</p>

<h5>1. Chọn sản phẩm</h5>
<ul>
    <li>Truy cập website và chọn sản phẩm muốn mua.</li>
    <li>Nhấn vào nút <strong>Trả góp</strong> (nếu sản phẩm hỗ trợ).</li>
</ul>

<h5>2. Chọn hình thức trả góp</h5>
<ul>
    <li>Trả góp qua thẻ tín dụng (0% lãi suất).</li>
    <li>Trả góp qua công ty tài chính.</li>
</ul>

<h5>3. Điền thông tin</h5>
<ul>
    <li>Nhập đầy đủ thông tin cá nhân theo yêu cầu.</li>
    <li>Kiểm tra lại thông tin trước khi gửi.</li>
</ul>

<h5>4. Xét duyệt hồ sơ</h5>
<ul>
    <li>Hệ thống hoặc nhân viên sẽ liên hệ xác nhận.</li>
    <li>Thời gian duyệt thường từ vài phút đến vài giờ.</li>
</ul>

<h5>5. Nhận hàng</h5>
<ul>
    <li>Sau khi hồ sơ được duyệt, đơn hàng sẽ được xử lý.</li>
    <li>Giao hàng tận nơi hoặc nhận tại cửa hàng.</li>
</ul>

<h5>6. Thanh toán hàng tháng</h5>
<ul>
    <li>Thanh toán đúng hạn theo kỳ đã đăng ký.</li>
    <li>Có thể thanh toán qua ngân hàng hoặc ví điện tử.</li>
</ul>

<p><strong>Chỉ với vài bước đơn giản, bạn đã có thể sở hữu sản phẩm mong muốn mà không cần trả toàn bộ chi phí ngay lập tức.</strong></p>
";
                    break;

                case 'baohanh_hd':
                    $title = "Hướng dẫn bảo hành";
                    $content = "

<p>Để đảm bảo quyền lợi khi sản phẩm gặp sự cố, KIPEEDA hướng dẫn khách hàng quy trình bảo hành nhanh chóng và đơn giản như sau:</p>

<h5>1. Kiểm tra điều kiện bảo hành</h5>
<ul>
    <li>Đảm bảo sản phẩm còn thời hạn bảo hành.</li>
    <li>Lỗi phát sinh do nhà sản xuất (không phải do người dùng).</li>
</ul>

<h5>2. Chuẩn bị thông tin</h5>
<ul>
    <li>Hóa đơn mua hàng hoặc mã đơn hàng.</li>
    <li>Thông tin sản phẩm cần bảo hành.</li>
</ul>

<h5>3. Gửi yêu cầu bảo hành</h5>
<ul>
    <li>Liên hệ hotline hoặc đến trực tiếp cửa hàng KIPEEDA.</li>
    <li>Hoặc gửi sản phẩm về trung tâm bảo hành.</li>
</ul>

<h5>4. Kiểm tra và xử lý</h5>
<ul>
    <li>Kỹ thuật viên kiểm tra tình trạng sản phẩm.</li>
    <li>Xác định lỗi và phương án xử lý (sửa chữa hoặc thay thế).</li>
</ul>

<h5>5. Nhận lại sản phẩm</h5>
<ul>
    <li>Sau khi hoàn tất bảo hành, khách hàng nhận lại sản phẩm.</li>
    <li>Kiểm tra lại trước khi rời cửa hàng.</li>
</ul>

<h5>6. Thời gian xử lý</h5>
<ul>
    <li>Thông thường từ 3 - 7 ngày làm việc.</li>
    <li>Có thể lâu hơn nếu cần gửi hãng.</li>
</ul>

<p><strong>KIPEEDA luôn nỗ lực hỗ trợ bảo hành nhanh chóng để đảm bảo trải nghiệm tốt nhất cho khách hàng.</strong></p>
";
                    break;

                case 'buildpc':
                    $title = "Build PC";
                    $content = "


<p>KIPEEDA cung cấp dịch vụ build PC theo yêu cầu, giúp khách hàng dễ dàng sở hữu một bộ máy tính phù hợp với nhu cầu học tập, làm việc hoặc giải trí.</p>

<h5>1. Xác định nhu cầu sử dụng</h5>
<ul>
    <li>Học tập, văn phòng cơ bản.</li>
    <li>Chơi game, đồ họa.</li>
    <li>Lập trình, thiết kế chuyên sâu.</li>
</ul>

<h5>2. Lựa chọn linh kiện</h5>
<ul>
    <li><strong>CPU:</strong> Bộ xử lý trung tâm, quyết định hiệu năng tổng thể.</li>
    <li><strong>Mainboard:</strong> Bo mạch chủ tương thích với CPU.</li>
    <li><strong>RAM:</strong> 8GB - 32GB tùy nhu cầu.</li>
    <li><strong>Ổ cứng:</strong> SSD (tốc độ cao) hoặc HDD (lưu trữ lớn).</li>
    <li><strong>GPU:</strong> Card đồ họa cho gaming hoặc thiết kế.</li>
    <li><strong>PSU:</strong> Nguồn điện ổn định cho hệ thống.</li>
</ul>

<h5>3. Tư vấn cấu hình</h5>
<ul>
    <li>Đội ngũ kỹ thuật KIPEEDA sẽ tư vấn cấu hình phù hợp.</li>
    <li>Tối ưu hiệu năng theo ngân sách.</li>
</ul>

<h5>4. Lắp ráp và kiểm tra</h5>
<ul>
    <li>Tiến hành lắp ráp linh kiện.</li>
    <li>Test hiệu năng và độ ổn định trước khi giao.</li>
</ul>

<h5>5. Giao hàng và hỗ trợ</h5>
<ul>
    <li>Giao hàng tận nơi hoặc nhận tại cửa hàng.</li>
    <li>Hỗ trợ kỹ thuật sau khi mua.</li>
</ul>

<p><strong>KIPEEDA giúp bạn xây dựng bộ PC tối ưu nhất với chi phí hợp lý và hiệu năng cao.</strong></p>
";
                    break;
                default:
                    $title = "FAQ";
                    $content = "Vui lòng chọn nội dung.";
            }
            ?>

            <h4><?= $title ?></h4>
            <hr>

            <div class="faq-box">
                <?= $content ?>
            </div>

        </div>
    </div>

    <?php include "footer.php" ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
    <script src="public/js/faq.js"></script>
</body>

</html>