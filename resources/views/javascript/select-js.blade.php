{{-- Form field javascript --}}
@once('action-forms-scripts')
    <script defer $_key="{{ str()->uuid() }}">
        document.addEventListener('alpine:init', () => {
            // For searching elements like: search, combobox,...
            Alpine.data('formSelect', (element, parent = null, resultKey, resultValue, fromArray = null, fromUrl = null) => ({
                results: [],
                isLoading: false,
                element: element,
                parent: parent,
                fromUrl: fromUrl,
                fromArray: fromArray,
                resultKey: resultKey,
                resultValue: resultValue,
                searchType: fromUrl ? 'url' : 'array',
                // Init select element
                init() {
                    this.selectEngine();
                },
                // Search in element
                selectEngine() {
                    // Init loading flag
                    this.isLoading = true;
                    if(this.searchType === 'url') {
                        this.resultsFromUrl();
                    // Search type: from array
                    } else {
                        this.results = this.fromArray;
                        this.isLoading = false;
                    }
                },
                // Serch type: from request url/API
                resultsFromUrl() {
                    // If there is no url...
                    if(!this.fromUrl) {
                        return [];
                    }
                    // Query 
                    let query = this.parent.value || '';
                    // If there is a parent 
                    // Then get the value from the URL
                    fetch(this.fromUrl + query)
                        .then(response => response.json())
                        .then(data => {
                            // Get the results from the request
                            this.results = data;
                            // Then stop loading flag
                            this.isLoading = false;
                        });
                },
            }))
        })
    </script>
@endonce