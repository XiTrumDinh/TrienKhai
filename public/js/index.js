let btn = document.getElementById("btnCategory")
let bannerMenu = document.getElementById("bannerMenu")
let navMenu = document.getElementById("navMenu")

btn.onclick = function () {

    let rect = bannerMenu.getBoundingClientRect()

    // kiểm tra menu banner có trong màn hình không
    if (rect.top >= 0 && rect.bottom <= window.innerHeight) {

        bannerMenu.classList.add("highlight")

        setTimeout(function () {
            bannerMenu.classList.remove("highlight")
        }, 1500)

    } else {

        navMenu.classList.toggle("show")

    }

}

btn.onclick = function () {

    overlay.classList.add("show")

    bannerMenu.classList.add("highlight")

}
overlay.addEventListener("click", function () {
    overlay.classList.remove("show")
    navMenu.classList.remove("show")
})