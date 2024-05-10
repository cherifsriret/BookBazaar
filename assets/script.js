
let inputQty = document.querySelectorAll('.cart-qty');
inputQty.forEach(function(btn) {

    btn.addEventListener('change', function() {
        let newQty = this.value;
        let id = this.getAttribute('data-id');
        
        // Make an AJAX request to update the database
        let xhr = new XMLHttpRequest();
        xhr.open('POST', './update_cart');
        let formData = new FormData();
        
        // Add data to FormData object
        formData.append("qty", newQty);
        formData.append("id", id);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Cart quantity updated successfully');
                // Refresh the page
                location.reload();
            } else {
                console.error('Error updating cart quantity:', xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error('Error updating cart quantity:', xhr.statusText);
        };
        xhr.send(formData);
    });
});

let removeBtns = document.querySelectorAll('.cart-remove');
removeBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
        let id = this.getAttribute('data-id');
        // Make an AJAX request to update the database
        let xhr = new XMLHttpRequest();
        xhr.open('POST', './remove_from_cart');
        let formData = new FormData();
        
        // Add data to FormData object
        formData.append("id", id);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Item removed from cart successfully');
                // Refresh the page
                location.reload();
            } else {
                console.error('Error removing item from cart:', xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error('Error removing item from cart:', xhr.statusText);
        };
        xhr.send(formData);
    });
});

// search bar script

document.querySelector('.search_input').addEventListener('blur', function(e) {
    let searchContainer = this.closest('.search-box');
    if (searchContainer && !searchContainer.contains(e.relatedTarget)) {
        this.value = '';
        clearSuggestions();
    }
});



document.querySelector('.search_input').addEventListener('input', function() {
    // Get the search query
    let query = this.value;

    if (query.length < 1) {
        clearSuggestions();
        return;
    }

    // Échapper la valeur de la requête
    query = encodeURIComponent(query);

    // Faire une requête AJAX sécurisée
    let xhr = new XMLHttpRequest();
    xhr.open('GET', './search?query=' + query, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Manipulation de la réponse
            let suggestions = JSON.parse(xhr.responseText);
            displaySuggestions(suggestions);
        }
    };
    xhr.send();
});

// Fonction pour afficher les suggestions
function displaySuggestions(suggestions) {
    // Supprimer les suggestions existantes
    clearSuggestions();

    // Créer et ajouter de nouveaux éléments pour chaque suggestion
    let suggestionsList = document.createElement('ul');
    suggestionsList.classList.add('suggestions-list', 'm-0');
    suggestions.forEach(function(suggestion) {
        let suggestionItem = document.createElement('li');
        suggestionItem.classList.add('suggestion', 'py-1');

        let link = document.createElement('a');
        link.href = './book_details?id=' + encodeURIComponent(suggestion.data);

        let image = document.createElement('img');
        image.src = suggestion.image;
        image.alt = suggestion.title;

        let titleSpan = document.createElement('span');
        titleSpan.textContent = suggestion.title;

        link.appendChild(image);
        link.appendChild(titleSpan);
        suggestionItem.appendChild(link);
        suggestionsList.appendChild(suggestionItem);
    });

    document.querySelector('#bookSuggestions').appendChild(suggestionsList);
}

// Fonction pour supprimer les suggestions existantes
function clearSuggestions() {
    let suggestionsContainer = document.querySelector('#bookSuggestions');
    while (suggestionsContainer.firstChild) {
        suggestionsContainer.removeChild(suggestionsContainer.firstChild);
    }
}

