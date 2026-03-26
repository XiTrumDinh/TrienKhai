
function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;

    let subText = text.substring(0, maxLength);

    // cắt tới khoảng trắng gần nhất
    let lastSpace = subText.lastIndexOf(" ");
    if (lastSpace > 0) {
        subText = subText.substring(0, lastSpace);
    }

    return subText + "...";
}

document.querySelectorAll(".limit-50").forEach(el => {
    el.innerText = truncateText(el.innerText, 50);
});
