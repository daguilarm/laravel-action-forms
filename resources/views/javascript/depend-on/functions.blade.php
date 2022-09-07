{{-- Javascript: Depend On... --}}
@push('action-forms-scripts')
    <script $_key="{{ str()->uuid() }}">
        window.__dependOn = function(parent, type, value, key) {
            // Get all the elements
            [parent, child, childContainer, label, value] = window.__getElements(parent, key, value);
            // If element has not parent, then set all to default 
            if (parent === null) {
                // Set default values
                window.__setDefaultValues(parent, child);
                // The end
                return;
            }

            // Init all the elements
            window.__initElements(child, value);

            // If parent is a checkbox
            if(parent.getAttribute('type') === 'checkbox') {
                window.__parentIsCheckbox(parent, child, childContainer, label, type);

            // If parent is a input, textarea
            } else {
                window.__parentIsInput(parent, child, childContainer, label, type);
            }
        }

        window.__getElements = function(parent, key, value) {
            // Get the child values 
            childContainer = document.querySelector('[data-container="' + key + '"]');  
            child = document.querySelector('[data-element="' + key + '"]'); 
            label = document.getElementById('label-' + key);
            value = value > 0 ? true : false;
            // If is a string
            if (!parent.hasOwnProperty('value')) {
                parent = document.querySelector('[data-parent="parent__' + parent + '"]');  
            }
                
            return [parent, child, childContainer, label, value];
        }

        window.__setDefaultValues = function(parent, child) {
            // If not parent all default 
            if (parent === null) {
                // Default values
                child.disabled = false;
                childContainer.classList.remove('hidden');
                label.classList.remove('{{ config('action-forms.theme.disabled') }}');
            }
        }

        window.__initElements = function(child, value) {
            // If current element (child) is checked or not 
            if (child.getAttribute('type') === 'checkbox') {
                child.checked = value ? true : false;
            }
        }

        window.__parentIsInput = function(parent, child, childContainer, label, type) {
            if(parent.value) {
                // Hidden case
                if(type === 'hidden') {
                    childContainer.classList.remove('hidden');
                } else {
                    child.disabled = false;
                    label.classList.remove('{{ config('action-forms.theme.disabled') }}');
                }
            } else {
                window.__resetElement(child, childContainer, label, type);
            }
        }

        window.__parentIsCheckbox = function(parent, child, childContainer, label, type) {
            if(parent.checked) {
                // Hidden case
                if(type === 'hidden') {
                    childContainer.classList.remove('hidden');
                } else {
                    child.disabled = false;
                    label.classList.remove('{{ config('action-forms.theme.disabled') }}');
                }
            } else {
                window.__resetElement(child, childContainer, label, type);
            }
        }

        window.__resetElement = function(child, childContainer, label, type) {
            // Hidden case
            if(type === 'hidden') {
                childContainer.classList.add('hidden');
                child.value = '';
            } else {
                child.disabled = true;
                child.value = '';
                label.classList.add('{{ config('action-forms.theme.disabled') }}');
            }
        }
    </script>
@endpush