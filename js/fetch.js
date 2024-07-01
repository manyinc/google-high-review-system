// js/script.js

document.getElementById('search-input').addEventListener('input', function() {
    const searchQuery = this.value.toLowerCase();
    const cards = document.querySelectorAll('.card');
    let count = 0;
    
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(searchQuery)) {
            card.style.display = 'block';
            count++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('counter').textContent = 'Liczba wyświetlonych opinii: ' + count;
});
