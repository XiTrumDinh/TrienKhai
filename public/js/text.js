const chatBox = document.getElementById("chatMessages");
const form = document.getElementById("chatForm");
const params = new URLSearchParams(window.location.search);

// Lấy title giống hệt logic của PHP để khớp truy vấn SQL
let title = "";
if (params.get("product")) {
    title = "Tư vấn sản phẩm: " + params.get("product");
} else if (params.get("order")) {
    title = "Hỗ trợ đơn hàng: #" + params.get("order");
} else {
    title = params.get("title") || "";
}

function load() {
    const chatUser = params.get("chat_user") || "0";
    // EncodeURIComponent cực kỳ quan trọng khi title có dấu tiếng Việt hoặc ký tự đặc biệt
    const url = `text.php?load=1&title=${encodeURIComponent(title)}&chat_user=${chatUser}`;

    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(res => res.text())
        .then(data => {
            // Nếu có dữ liệu mới thì cập nhật, nếu không thì giữ nguyên
            if (data.trim() !== "") {
                chatBox.innerHTML = data;
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        })
        .catch(err => console.error("Lỗi load tin nhắn:", err));
}

// Gửi tin nhắn
form.addEventListener("submit", e => {
    e.preventDefault();
    let msgInput = document.getElementById("message");
    let msg = msgInput.value.trim();
    if (!msg) return;

    let fd = new FormData();
    fd.append("ajax", "send");
    fd.append("message", msg);
    fd.append("title", title); // Gửi title gốc

    let receiver = document.getElementById("receiver_id");
    if (receiver) fd.append("receiver_id", receiver.value);

    fetch("text.php", {
        method: "POST",
        body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(res => {
            if (res.ok) {
                msgInput.value = "";
                load(); // Gọi load ngay để hiện tin nhắn vừa gửi
            }
        });
});

// Chạy lần đầu và lặp lại
load();
