// js/contact-form.js

// Funkcja do odczytania parametru 'rating' z URL-a
function getRatingFromURL() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    return urlParams.get('rating');
}

// Pobranie oceny z URL-a i ustawienie wybranej liczby gwiazdek
const ratingFromURL = getRatingFromURL();
if (ratingFromURL) {
    const stars = document.querySelectorAll('.star');
    stars.forEach(star => {
        const value = star.getAttribute('data-value');
        if (value <= ratingFromURL) {
            star.classList.add('selected');
        }
    });
    document.getElementById('rating').value = ratingFromURL;
}

const stars = document.querySelectorAll('.star');
const ratingInput = document.getElementById('rating');


stars.forEach(star => {
    star.addEventListener('click', () => {
        const value = star.getAttribute('data-value');
        if (value == 5) {
            window.location.href = ''; // add a link to your company's rating on Google
        } 
        ratingInput.value = value;
        stars.forEach(s => s.classList.remove('selected'));
        star.classList.add('selected');
        for(let i = 0; i < value; i++) {
            stars[i].classList.add('selected');
        }
    });

    star.addEventListener('mouseover', () => {
        resetStars();
        highlightStars(star);
    });

    star.addEventListener('mouseout', () => {
        resetStars();
        const selectedValue = ratingInput.value;
        if (selectedValue) {
            for(let i = 0; i < selectedValue; i++) {
                stars[i].classList.add('selected');
            }
        }
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
