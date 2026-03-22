
document.querySelectorAll('.quantity').forEach(q => {
    const input = q.querySelector('input');
    q.querySelector('.plus').addEventListener('click', () => {
        input.value = parseInt(input.value) + 1;
    });
    q.querySelector('.minus').addEventListener('click', () => {
        if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    });
});
