
<div class="row justify-content-center search-box">
    <div class="d-flex justify-content-center h-100">
        <div class="searchbar">
            <input class="search_input" type="text" name="" placeholder="Search...">
            <a href="#" class="search_icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </a>
        </div>
    </div>

    <div id="bookSuggestions" class="p-0 mt-1" ></div>

    <!--end of col-->
</div>




<script>
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
               


                  //  suggestionsHtml += '<li class="suggestion"> <a href="./book_details?id='+suggestion.data+'">' + suggestion.value + '</a></li>';
                });

                suggestionsHtml = '<ul class="suggestions-list m-0">' + suggestionsHtml + '</ul>';

                document.querySelector('#bookSuggestions').innerHTML = suggestionsHtml;

            }
        };
        xhr.send();
    });

    document.querySelector('.search_input').addEventListener('blur', function() {
       
        setTimeout(() => {
            this.value = '';
            document.querySelector('#bookSuggestions').innerHTML = '';
        }, 400);
     
    });
</script>