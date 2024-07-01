// js/rating.js

const stars = document.querySelectorAll('.star');

stars.forEach(star => {
    star.addEventListener('click', () => {
        const value = star.getAttribute('data-value');
        if (value == 5) {
            window.location.href = ''; //add a link to your company's rating on Google
        } else {
            window.location.href = `contact-form.html?rating=${value}`;
        }
    });

    star.addEventListener('mouseover', () => {
        resetStars();
        highlightStars(star);
    });

    star.addEventListener('mouseout', () => {
        resetStars();
    });
});

function highlightStars(star) {
    star.classList.add('hovered');
    let previousSibling = star.previousElementSibling;
    while (previousSibling) {
        previousSibling.classList.add('hovered');
        previousSibling = previousSibling.previousElementSibling;
    }
}

function resetStars() {
    stars.forEach(star => {
        star.classList.remove('hovered');
    });
}
