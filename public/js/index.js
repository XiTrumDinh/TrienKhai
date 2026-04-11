let btn = document.getElementById("btnCategory");
let bannerMenu = document.getElementById("bannerMenu");
let navMenu = document.getElementById("navMenu");
let overlay = document.getElementById("overlay");

btn.onclick = function (e) {
    e.preventDefault();
    e.stopPropagation();

    // 1. Nếu là MÀN HÌNH NHỎ (Mobile/Tablet)
    if (window.innerWidth <= 768) {
        navMenu.classList.toggle("show");
        // Không dùng overlay ở mobile để tránh bị đen màn hình
        return;
    }

    // 2. Nếu là MÁY TÍNH (PC)
    let rect = bannerMenu.getBoundingClientRect();

    // Kiểm tra xem banner có đang hiển thị trên màn hình không
    if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
        // Có thấy banner -> Highlight banner (Hình 3)
        bannerMenu.classList.add("highlight");
        bannerMenu.classList.add("show-all");

        setTimeout(function () {
            bannerMenu.classList.remove("highlight");
        }, 1500);
    } else {
        // Không thấy banner -> Hiện menu thả xuống ở Navbar
        navMenu.classList.toggle("show");
    }

    // Hiện màn hình mờ ở PC
    if (overlay) overlay.classList.add("show");
}

// Click ra ngoài để đóng menu
document.addEventListener("click", function (e) {
    if (!navMenu.contains(e.target) && e.target !== btn) {
        navMenu.classList.remove("show");
        if (overlay) overlay.classList.remove("show");
        if (bannerMenu) bannerMenu.classList.remove("show-all");
    }
});

if (overlay) {
    overlay.onclick = function () {
        navMenu.classList.remove("show");
        overlay.classList.remove("show");
        bannerMenu.classList.remove("show-all");
    }
}