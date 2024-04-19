
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



 