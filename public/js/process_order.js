let time = 10;
const countEl = document.getElementById("time"); 

const timer = setInterval(() => {
    time--;
    countEl.innerText = time;

    if (time <= 0) {
        clearInterval(timer);
        goToTracking();
    }
}, 1000);

function goToTracking() {
    window.location.href = "shipping.php";
}