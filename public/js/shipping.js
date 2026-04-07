
function showStep(index) {
    const steps = document.querySelectorAll(".step");
    const contents = document.querySelectorAll(".content");

    steps.forEach(s => s.classList.remove("active"));
    contents.forEach(c => c.classList.remove("active"));

    steps[index].classList.add("active");
    contents[index].classList.add("active");
}
