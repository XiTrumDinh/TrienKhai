
document.querySelectorAll(".footer-title").forEach(title => {

    title.addEventListener("click", () => {

        if (window.innerWidth <= 768) {

            let content = title.nextElementSibling

            content.style.display =
                content.style.display === "block" ? "none" : "block"

        }

    })

})
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

btn.onclick = function(){

overlay.classList.add("show")

menu.classList.add("highlight")

}
overlay.onclick = function(){

overlay.classList.remove("show")

menu.classList.remove("highlight")

}