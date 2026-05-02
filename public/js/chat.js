const chatBox = document.getElementById("chatMessages");
const form = document.getElementById("chatForm");

const params = new URLSearchParams(window.location.search);

let title = "";

if (params.get("product")) {
    title = "Tư vấn sản phẩm: " + params.get("product");

} else if (params.get("order")) {
    title = "Hỗ trợ đơn hàng: #" + params.get("order");

} else {
    title = params.get("title");
}

function load() {
    fetch(`chat.php?load=1&title=${encodeURIComponent(title)}&chat_user=${params.get("chat_user") || ""}`)
        .then(res => res.text())
        .then(data => {
            chatBox.innerHTML = data;
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

form.addEventListener("submit", e => {
    e.preventDefault();

    let msg = document.getElementById("message").value;

    let fd = new FormData();
    fd.append("ajax", "send");
    fd.append("message", msg);
    fd.append("title", title);

    let receiver = document.getElementById("receiver_id");
    if (receiver) fd.append("receiver_id", receiver.value);

    fetch("chat.php", { method: "POST", body: fd })
        .then(() => {
            document.getElementById("message").value = "";
            load();
        });
});

setInterval(load, 1000);
load();