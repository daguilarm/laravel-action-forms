{{-- Form field javascript --}}
@once('action-forms-scripts')
    <script defer $_key="{{ str()->uuid() }}">
        document.addEventListener('alpine:init', () => {
            // For searching elements like: search, combobox,...
            Alpine.data('formSearch', (element, requestId, requestValue, requestFromArray = null, requestFrom = null, minChars = 1) => ({
                searchElement: '',
                searchResults: [],
                isLoading: false,
                element: element,
                minChars: minChars,
                requestFrom: requestFrom,
                requestFromArray: requestFromArray,
                requestId: requestId,
                requestValue: requestValue,
                searchType: requestFrom ? 'request' : 'array',
                // Search in element
                searchEngine() {
                    // If query string is has enought length... 
                    // Start to search
                    if(this.searchElement.length >= this.minChars) {
                        // Init loading flag
                        this.isLoading = true;
                        // Serch type: from request url/API
                        if(this.searchType === 'request') {
                            this.searchFromRequest();
                        // Search type: from array
                        } else {
                            this.searchArray();
                        }
                    }
                },
                // Serch type: from request url/API
                searchFromRequest() {
                    // Request url
                    fetch(this.requestFrom + this.searchElement)
                        .then(response => response.json())
                        .then(data => {
                            // Get the results from the request
                            this.searchResults = data;
                            // Then stop loading flag
                            this.isLoading = false;
                        });
                },
                // Search type: from array
                searchArray() {
                    // Lowercase the query string
                    let query = this.searchElement.toLowerCase();
                    // Get the results from the array
                    this.searchResults = this.filterArray(query, this.requestValue);
                    // Then stop loading flag
                    this.isLoading = false;
                },
                // Array search
                filterArray(query, requestValue) {
                    return this.requestFromArray
                        .filter(function(el) {
                            return eval('el.' + requestValue).toLowerCase().indexOf(query.toLowerCase()) > -1;
                        });
                },
                // Select element from search
                selectElement(data) {
                    // Reset results
                    this.searchResults = 0;
                    // Add value to hidden field (ID)
                    this.getHiddenElement().value = eval('data.' + this.requestId);
                    // Add value to field (TEXT)
                    this.value = eval('data.' + this.requestValue);
                },
                // Get the hidden field
                getHiddenElement() {
                    return document.querySelector('[data-element="hidden__' + this.element + '"]');
                // Reset element
                resetElement() {
                    this.searchResults = 0;
                    this.value = '';
                },
                // Show or hide element
                showElement() {
                    return this.searchResults.length > 0;
                }
            }))
        })
    </script>
@endonce