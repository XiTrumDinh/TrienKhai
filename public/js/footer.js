
document.querySelectorAll(".footer-title").forEach(title => {
    title.addEventListener("click", () => {

        const parent = title.parentElement;
        const content = parent.querySelector(".footer-content");

        parent.classList.toggle("active");

        content.style.display =
            content.style.display === "block" ? "none" : "block";
    });
});
