<?php
// Tắt hiển thị lỗi HTML để tránh làm hỏng cấu trúc dữ liệu JSON trả về
header('Content-Type: application/json');
ini_set('display_errors', 0);

// ĐÃ SỬA: Trỏ vào thư mục con content/
$uploadDir = "../public/uploads/content/";
if (!file_exists($uploadDir)) {
    // Quyền 0777 và bật chế độ đệ quy (true) để tự tạo thư mục 'content' nếu chưa có
    mkdir($uploadDir, 0777, true);
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Định dạng ảnh không hợp lệ!']);
        exit;
    }

    // Đặt tên file ngẫu nhiên để tránh trùng lặp
    $filename = time() . "_" . uniqid() . "." . $ext;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
        // ĐÃ SỬA: Thêm content/ để link thẻ <img> ở frontend nhận đúng ảnh
        $url = "public/uploads/content/" . $filename;
        echo json_encode(['success' => true, 'url' => $url]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể di chuyển file upload.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy file hoặc file bị lỗi.']);
}