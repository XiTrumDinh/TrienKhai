
function toggleFaq(el) {
    const parent = el.parentElement;
    const list = parent.querySelector(".faq-list");

    parent.classList.toggle("active");

    list.style.display =
        list.style.display === "block" ? "none" : "block";
}
