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
                window.__af_setDefaultValues(parent, child, label);
                // The end
                return;
            }
            // Init all the elements
            window.__af_initElements(child, value);
            // If parent is a checkbox
            if(parent.getAttribute('type') === 'checkbox') {
                window.__af_parentIsCheckbox(parent, child, childContainer, label, type);
            // If parent is a input, textarea
            } else {
                window.__af_parentIsInput(parent, child, childContainer, label, type);
            }
        }
        // Get all the elements
        window.__af_getElements = function(parent, key, value) {
            // Get the child values 
            childContainer = document.querySelector('[data-container="' + key + '"]');  
            // All the children (querySelectorAll)
            child = document.querySelectorAll('[data-element="' + key + '"]'); 
            label = document.getElementsByClassName('af_element_disabled_' + key);
            value = value > 0 ? true : false;
            // If is a string
            if (!parent.hasOwnProperty('value')) {
                parent = document.querySelector('[data-parent="parent__' + parent + '"]');  
            }  
            return [parent, child, childContainer, label, value];
        }
        // Set the default values
        window.__af_setDefaultValues = function(parent, child, label) {
            // Show the container
            childContainer.classList.remove('hidden');
            // Default values: remove the disabled state
            child.forEach(function(element) {
                element.disabled = false;
            });
            // Enable all the labels
            [].map.call(label, element => element.classList.remove('{{ config('action-forms.theme.disabled') }}'));
        }
        // Init the elements
        window.__af_initElements = function(child, value) {
            child.forEach(function(element) {
                // If current element (child) is checked or not 
                if (element.getAttribute('type') === 'checkbox') {
                    element.checked = value ? true : false;
                }
            });
        }
        // If the parent is an input or textarea
        window.__af_parentIsInput = function(parent, child, childContainer, label, type) {
            if(parent.value) {
                // Hidden case
                if(type === 'hidden') {
                    childContainer.classList.remove('hidden');
                } else {
                    // All the children: remove the disabled state
                    child.forEach(function(element) {
                        element.disabled = false;
                    });
                    // Enable all the labels
                    [].map.call(label, element => element.classList.remove('{{ config('action-forms.theme.disabled') }}'));
                }
            } else {
                window.__af_resetElement(child, childContainer, label, type);
            }
        }
        // If the parent is a checkbox
        window.__af_parentIsCheckbox = function(parent, child, childContainer, label, type) {
            if(parent.checked) {
                // Hidden case
                if(type === 'hidden') {
                    childContainer.classList.remove('hidden');
                } else {
                    // All the children: remove the disabled state
                    child.forEach(function(element) {
                        element.disabled = false;
                    });
                    // Enable all the labels
                    [].map.call(label, element => element.classList.remove('{{ config('action-forms.theme.disabled') }}'));
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
                    // All the children: reset the value
                    child.forEach(function(element) {
                        element.value = '';
                    });
                @endif
            } else {
                // All the children: add the disabled state
                child.forEach(function(element) {
                    element.disabled = true;
                });
                // Disable all the labels
                [].map.call(label, element => element.classList.add('{{ config('action-forms.theme.disabled') }}'));
                // Reset child if parent is disabled
                @if(config('action-forms.reset_disabled'))
                    // All the children: reset the value
                    child.forEach(function(element) {
                        element.value = '';
                    });
                @endif
            }
            // Reset the counter if...
            window.__af_updateTextAreaCount(child);
        }
        // Reset the textarea count
        window.__af_updateTextAreaCount = function(child, count = 0, element = null) {
            // Remember we are working with a list of children.
            // The textarea allways has only one element.
            // So just take the first one (an unique) for fire an event.
            child[0].dispatchEvent(new CustomEvent('updatecounter', {detail: {value: count}}));
        }
    </script>
@endpush