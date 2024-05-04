
var inputQty = document.querySelectorAll('.cart-qty');
inputQty.forEach(function(btn) {

    btn.addEventListener('change', function() {
        var newQty = this.value;
        var id = this.getAttribute('data-id');
        
        // Make an AJAX request to update the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './update_cart');
        var formData = new FormData();
        
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

var removeBtns = document.querySelectorAll('.cart-remove');
removeBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        // Make an AJAX request to update the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './remove_from_cart');
        var formData = new FormData();
        
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
// Add event listener to the search input
document.querySelector('.search_input').addEventListener('input', function() {
    // Get the search query
    var query = this.value;

    if (query.length < 1) {
        document.querySelector('#bookSuggestions').innerHTML = '';
        return;
    }
    // Make an AJAX request to fetch book suggestions
    var xhr = new XMLHttpRequest();
    xhr.open('GET', './search?query=' + query, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Handle the response
            var suggestions = JSON.parse(xhr.responseText);
            var suggestionsHtml = '';
            suggestions.forEach(function(suggestion) {
                suggestionsHtml += '<li class="suggestion py-1"> <a href="./book_details?id=' + suggestion.data + '">';
                suggestionsHtml += '<img src="' + suggestion.image + '" alt="' + suggestion.title + '">';
                suggestionsHtml += '<span>' + suggestion.title + '</span>';
                suggestionsHtml += '</a></li>';
            });

            suggestionsHtml = '<ul class="suggestions-list m-0">' + suggestionsHtml + '</ul>';
            document.querySelector('#bookSuggestions').innerHTML = suggestionsHtml;
        }
    };
    xhr.send();
});
document.querySelector('.search_input').addEventListener('blur', function(e) {
    var searchContainer = this.closest('.search-box');
    if (searchContainer && !searchContainer.contains(e.relatedTarget)) {
        this.value = '';
        document.querySelector('#bookSuggestions').innerHTML = '';
    }
});


 