{{-- Javascript: Depend On... --}}
@push('action-forms-scripts')
    <script $_key="{{ str()->uuid() }}">
        // Dependent base function
        window.__af_dependOn = function(parent, type, value, key) {
            // Get all the elements
            [parent, child, childContainer, label, value] = window.__af_getElements(parent, key, value);
            // If element has not parent, then set all to default 
            if (parent === null) {
                // Set default values
                window.__af_setDefaultValues(parent, child);
                // The end
                return;
            }
            // Init all the elements
            window.__af_initElements(child, value);
            // If parent is a checkbox
            if(parent.getAttribute('type') === 'checkbox') {
                window.__parentIsCheckbox(parent, child, childContainer, label, type);
            // If parent is a input, textarea
            } else {
                window.__af_parentIsInput(parent, child, childContainer, label, type);
            }
        }
        // Get all the elements
        window.__af_getElements = function(parent, key, value) {
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
        // Set the default values
        window.__af_setDefaultValues = function(parent, child) {
            // If not parent all default 
            if (parent === null) {
                // Default values
                child.disabled = false;
                childContainer.classList.remove('hidden');
                label.classList.remove('{{ config('action-forms.theme.disabled') }}');
            }
        }
        // Init the elements
        window.__af_initElements = function(child, value) {
            // If current element (child) is checked or not 
            if (child.getAttribute('type') === 'checkbox') {
                child.checked = value ? true : false;
            }
        }
        // If the parent is an input or textarea
        window.__af_parentIsInput = function(parent, child, childContainer, label, type) {
            if(parent.value) {
                // Hidden case
                if(type === 'hidden') {
                    childContainer.classList.remove('hidden');
                } else {
                    child.disabled = false;
                    label.classList.remove('{{ config('action-forms.theme.disabled') }}');
                }
            } else {
                window.__af_resetElement(child, childContainer, label, type);
            }
        }
        // If the parent is a checkbox
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
                window.__af_resetElement(child, childContainer, label, type);
            }
        }
        // Reset the element
        window.__af_resetElement = function(child, childContainer, label, type) {
            // Hidden case
            if(type === 'hidden') {
                childContainer.classList.add('hidden');
                // Reset child if parent is disabled
                @if(config('action-forms.reset_disabled'))
                    child.value = '';
                @endif
            } else {
                child.disabled = true;
                label.classList.add('{{ config('action-forms.theme.disabled') }}');
                // Reset child if parent is disabled
                @if(config('action-forms.reset_disabled'))
                    child.value = '';
                @endif
            }
        }
    </script>
@endpush