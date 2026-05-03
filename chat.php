<?php
session_start();
include "Database/Database.php";

$db = new Database();
$conn = $db->getConnection();

/* ===== LOGIN ===== */
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Vui lòng đăng nhập!');window.location='login.php';</script>";
    exit;
}

$user_id   = (int) $_SESSION['id'];
$user_role = $_SESSION['role'];
$admin_id  = 1;

function safe($str)
{
    return htmlspecialchars($str ?? '');
}

/* ===== USERNAME ===== */
$getUser = $conn->prepare("SELECT username FROM users WHERE id=?");
$getUser->bind_param("i", $user_id);
$getUser->execute();
$username = $getUser->get_result()->fetch_assoc()['username'] ?? 'Unknown';

/* ===== CHAT TITLE ===== */
$chat_title = '';
if (!empty($_GET['product'])) {
    $chat_title = "Tư vấn sản phẩm: " . $_GET['product'];
} elseif (!empty($_GET['order'])) {
    $chat_title = "Hỗ trợ đơn hàng: #" . $_GET['order'];
} elseif (!empty($_GET['title'])) {
    $chat_title = $_GET['title'];
}

/* ===== CHẶN USER TRUY CẬP LÉN ===== */
if ($user_role === 'user' && !empty($chat_title)) {
    $check = $conn->prepare("
        SELECT id FROM messages
        WHERE user_id=? AND chat_title=?
        LIMIT 1
    ");
    $check->bind_param("is", $user_id, $chat_title);
    $check->execute();

    if ($check->get_result()->num_rows == 0) {
        echo "<script>alert('Không có quyền!');location='chat.php';</script>";
        exit;
    }
}

/* ===== TẠO CHAT ===== */
if (!empty($chat_title) && $user_role === 'user') {
    $check = $conn->prepare("
        SELECT id FROM messages
        WHERE user_id=? AND chat_title=?
        LIMIT 1
    ");
    $check->bind_param("is", $user_id, $chat_title);
    $check->execute();

    if ($check->get_result()->num_rows == 0) {
        $stmt = $conn->prepare("
            INSERT INTO messages
            (sender, message, user_id, role, sender_id, receiver_id, chat_title)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssisiss",
            $username,
            $chat_title,
            $user_id,
            $user_role,
            $user_id,
            $admin_id,
            $chat_title
        );
        $stmt->execute();
    }
}

/* ===== SEND ===== */
if (isset($_POST['ajax']) && $_POST['ajax'] === 'send') {

    $msg = trim($_POST['message'] ?? '');
    $title = $_POST['title'] ?? '';
    if ($msg === '') exit;

    if ($user_role === 'user') {
        $receiver = $admin_id;
        $chat_uid = $user_id;

        $check = $conn->prepare("
            SELECT id FROM messages WHERE user_id=? AND chat_title=?
        ");
        $check->bind_param("is", $user_id, $title);
        $check->execute();
        if ($check->get_result()->num_rows == 0) exit;
    } else {
        $receiver = (int)($_POST['receiver_id'] ?? 0);
        if ($receiver <= 0) exit;
        $chat_uid = $receiver;
    }

    $stmt = $conn->prepare("
        INSERT INTO messages
        (sender, message, user_id, role, sender_id, receiver_id, chat_title)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssisiss",
        $username,
        $msg,
        $chat_uid,
        $user_role,
        $user_id,
        $receiver,
        $title
    );
    $stmt->execute();
    exit;
}

/* ===== LOAD ===== */
if (isset($_GET['load'])) {

    $title = $_GET['title'] ?? '';

    if (in_array($user_role, ['admin', 'tuvan'])) {

        $chat_user = (int)($_GET['chat_user'] ?? 0);

        $stmt = $conn->prepare("
            SELECT * FROM messages
            WHERE chat_title=? AND user_id=?   -- 🔥 FIX TRỘN CHAT
            ORDER BY created_at ASC
        ");
        $stmt->bind_param("si", $title, $chat_user);
    } else {

        $stmt = $conn->prepare("
            SELECT * FROM messages
            WHERE user_id=? AND chat_title=? AND receiver_id=?
            ORDER BY created_at ASC
        ");
        $stmt->bind_param("isi", $user_id, $title, $admin_id);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $class = ($row['sender_id'] == $user_id) ? 'user' : 'admin';
        echo "<div class='message $class'>
                <b>" . safe($row['sender']) . ":</b>
                <span>" . safe($row['message']) . "</span>
              </div>";
    }
    exit;
}

/* ===== CHAT NAME ===== */
$chat_with_name = '';
if (!empty($chat_title)) {

    $stmt = $conn->prepare("
        SELECT sender FROM messages
        WHERE chat_title=? AND sender_id!=? AND user_id=?
        ORDER BY created_at DESC LIMIT 1
    ");
    $stmt->bind_param("sii", $chat_title, $user_id, $user_id);
    $stmt->execute();

    $r = $stmt->get_result()->fetch_assoc();
    if ($r) $chat_with_name = $r['sender'];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Realtime</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/chat.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="contact-container">

        <div class="contact-sidebar">
            <h5>Hỗ trợ</h5>

            <?php
            if (in_array($user_role, ['admin', 'tuvan'])) {

                echo "<h6>Danh sách chat</h6>";

                $chats = mysqli_query($conn, "
        SELECT 
            m.user_id,
            m.chat_title,
            u.username,

            (
                SELECT sender FROM messages
                WHERE chat_title = m.chat_title
                AND user_id = m.user_id  -- 🔥 FIX QUAN TRỌNG
                AND sender_id != m.user_id
                ORDER BY created_at DESC LIMIT 1
            ) AS staff_name,

            MAX(m.created_at) as last_time

        FROM messages m
        JOIN users u ON u.id = m.user_id

        GROUP BY m.user_id, m.chat_title, u.username
        ORDER BY last_time DESC
    ");
            } else {

                echo "<h6>Chat của bạn</h6>";

                $chats = mysqli_query($conn, "
        SELECT 
            m.user_id,
            m.chat_title,
            u.username,

            (
                SELECT sender FROM messages
                WHERE chat_title = m.chat_title
                AND user_id = m.user_id
                AND sender_id != m.user_id
                ORDER BY created_at DESC LIMIT 1
            ) AS staff_name,

            MAX(m.created_at) as last_time

        FROM messages m
        JOIN users u ON u.id = m.user_id

        WHERE m.user_id = $user_id
        GROUP BY m.user_id, m.chat_title, u.username
        ORDER BY last_time DESC
    ");
            }

            while ($c = mysqli_fetch_assoc($chats)):

                $name = ($user_role === 'user')
                    ? ($c['staff_name'] ?: 'Chưa phản hồi')
                    : $c['username'];
            ?>

                <a href="?chat_user=<?= $c['user_id'] ?>&title=<?= urlencode($c['chat_title']) ?>">
                    <div style="font-weight:600"><?= safe($name) ?></div>
                    <div style="font-size:13px;color:#666"><?= safe($c['chat_title']) ?></div>
                </a>

            <?php endwhile; ?>
        </div>


        <div class="contact-content">
            <h4>Liên hệ hỗ trợ</h4>

            <?php if ($chat_with_name): ?>
                <div style="margin-bottom:10px; font-weight:500; color:#555;">
                    Đang chat với: <b><?= safe($chat_with_name) ?></b>
                </div>
            <?php endif; ?>

            <div class="chat-box">
                <div class="chat-messages" id="chatMessages"></div>

                <form id="chatForm" class="chat-input">
                    <input type="text" id="message" placeholder="Nhập tin nhắn..." required>

                    <?php if (in_array($user_role, ['admin', 'tuvan'])): ?>
                        <input type="hidden" id="receiver_id"
                            value="<?= (int) ($_GET['chat_user'] ?? 0) ?>">
                    <?php endif; ?>

                    <button type="submit">Gửi</button>
                </form>
            </div>
        </div>

    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/footer.js"></script>
    <script src="public/js/chat.js"></script>

</body>

</html>