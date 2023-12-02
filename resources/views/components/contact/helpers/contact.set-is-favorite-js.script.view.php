<?php declare(strict_types=1); ?>

<script>
    let is_favorite_input = document.getElementById('is_favorite');
    let favoriteButtonContainer = document.getElementById('favorite_button_container');
    let favoriteButton = document.getElementById('favorite_button');
    let badge = document.querySelector('.badge');

    favoriteButtonContainer.addEventListener('click', function () {
        is_favorite_input.checked = !is_favorite_input.checked
        is_favorite_input.dispatchEvent(new Event('change'));
    });

    is_favorite_input.addEventListener('change', function () {
        if (!this.checked) {
            badge.textContent = 'Common';
            badge.className = 'col-3 badge text-secondary fs-5';
            favoriteButtonContainer.innerHTML = `
                <button type="button" class="btn btn-outline-success w-100" id="favorite_button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                         fill="currentColor"
                         class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                    <span class="ps-2">Mark as favorite</span>
                </button>
                `
        } else {
            badge.textContent = 'Favorite';
            badge.className = 'col-3 badge text-success fs-5';
            favoriteButtonContainer.innerHTML = `
                <button type="button" class="btn btn-outline-secondary w-100" id="favorite_button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                         fill="currentColor"
                         class="bi bi-slash-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M11.354 4.646a.5.5 0 0 0-.708 0l-6 6a.5.5 0 0 0 .708.708l6-6a.5.5 0 0 0 0-.708z"/>
                    </svg>
                    <span class="ps-2">Unmark as favorite</span>
                </button>
                `
        }
    });
</script>