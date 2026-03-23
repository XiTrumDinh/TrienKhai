
document.querySelectorAll(".footer-title").forEach(title => {

    title.addEventListener("click", () => {

        if (window.innerWidth <= 768) {

            let content = title.nextElementSibling

            content.style.display =
                content.style.display === "block" ? "none" : "block"

        }

    })

})
