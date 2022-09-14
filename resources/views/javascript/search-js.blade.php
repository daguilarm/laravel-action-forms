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
                requestId: requestId,
                requestValue: requestValue,
                minChars: minChars,
                requestFrom: requestFrom,
                requestFromArray: requestFromArray,
                searchType: requestFrom ? 'request' : 'array',
                searchEngine() {
                    if(this.searchElement.length >= this.minChars) {
                        this.isLoading = true;
                        if(this.searchType === 'request') {
                            this.searchFromRequest();
                        } else {
                            this.searchArray();
                        }
                    }
                },
                searchFromRequest() {
                    fetch(this.requestFrom + this.searchElement)
                        .then(response => response.json())
                        .then(data => {
                            this.searchResults = data;
                            this.isLoading = false;
                        });
                },
                searchArray() {
                    let query = this.searchElement.toLowerCase();
                    this.searchResults = this.filterArray(query, this.requestValue);
                    this.isLoading = false;
                },
                filterArray(query, requestValue) {
                    return this.requestFromArray
                        .filter(function(el) {
                            return eval('el.' + requestValue).toLowerCase().indexOf(query.toLowerCase()) > -1;
                        });
                },
                selectElement(data) {
                    this.searchResults = 0;
                    this.getHiddenElement().value = eval('data.' + this.requestId);
                    this.value = eval('data.' + this.requestValue);
                },
                getHiddenElement() {
                    return document.querySelector('[data-element="hidden__' + this.element + '"]');
                },
                resetElement() {
                    this.searchResults = 0;
                    this.value = '';
                },
                showElement() {
                    return this.searchResults.length > 0;
                }
            }))
        })
    </script>
@endonce