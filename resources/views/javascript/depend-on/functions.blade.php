{{-- Javascript: Depend On... --}}
@push('action-forms-scripts')
    <script $_key="{{ str()->uuid() }}">
        // Dependent base function
        __af_dependOn = function(parent, type, value, dependValue, key) {
            // Get all the elements
            [parent, child, childContainer, label, value] =__af_getElements(parent, key, value);
            // If element has not parent, then set all to default 
            if (parent === null) {
                // Set default values
                __af_setDefaultValues(parent, child, label);
                // The end
                return;
            }
            // Init all the elements
            __af_initElements(child, value);
            // Do the magic
            // If parent is a checkbox
            if(parent.getAttribute('type') === 'checkbox' || parent.getAttribute('type') === 'radio') {
                return __af_parentIsActive(parent, child, childContainer, label, type, parent.checked, dependValue);
            } 
            // If parent is a input, textarea
            return __af_parentIsActive(parent, child, childContainer, label, type, parent.value, dependValue);
        }
        __af_dependOnRadio = function(currentField, type, value) {
            // All the childs
            let children = document.querySelectorAll('[data-depend="depend_on__' + currentField.name + '"]');
            // If parent...
            let label = document.getElementsByClassName('af_element_disabled_' + currentField.dataset.element);
            let container = currentField.dataset.container;
            __af_parentIsActiveExecuteAction(children, container, label, type);
        }
        // Get all the elements
        __af_getElements = function(parent, key, value) {
            // Get the child values 
            let childContainer = document.querySelector('[data-container="' + key + '"]');  
            // All the children (querySelectorAll)
            let child = document.querySelectorAll('[data-element="' + key + '"]'); 
            let label = document.getElementsByClassName('af_element_disabled_' + key);
            value = value > 0 ? true : false;
            // If is a string
            if (!parent.hasOwnProperty('value')) {
                parent = document.querySelector('[data-parent="parent__' + parent + '"]');
                // Radio button case -> multiple elements with the same value
                if(parent.getAttribute('type') === 'radio' && parent.value) {
                    parent = document.querySelector('input[data-parent="parent__' + parent + '"]:checked');
                }
            }  

            return [parent, child, childContainer, label, value];
        }
        // Set the default values
        __af_setDefaultValues = function(parent, child, label) {
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
        __af_initElements = function(child, value) {
            child.forEach(function(element) {
                // If current element (child) is checked or not 
                if (element.getAttribute('type') === 'checkbox') {
                    element.checked = element.dataset.checked === 1 ? true : false;
                }
            });
        }
        // If the parent is active: has value or is checked
        __af_parentIsActive = function(parent, child, childContainer, label, type, condition, dependValue) {
            if(dependValue && dependValue === parent.value && condition) {
                __af_parentIsActiveExecuteAction(child, childContainer, label, type);
            } else if(!dependValue && condition) {
                __af_parentIsActiveExecuteAction(child, childContainer, label, type);
            } else {
                // Reset all children
                __af_resetElement(child, childContainer, label, type);
            }
        }
        // Execute action if parent is active
        __af_parentIsActiveExecuteAction = function(child, childContainer, label, type) {
            // Hidden case
            if(type === 'hidden') {
                childContainer.classList.remove('hidden');
            } else {
                // All the children: remove the disabled state
                child.forEach(function(element) {
                    element.disabled = false;
                });
                // Enable all the labels
                Array
                    .prototype
                    .map
                    .call(label, element => element.classList.remove('{{ config('action-forms.theme.disabled') }}'));
            }
        }
        // Reset the element
        __af_resetElement = function(child, childContainer, label, type) {
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
                    element.checked = false;
                    // Reset child if parent is disabled
                    @if(config('action-forms.reset_disabled'))
                        // All the children: reset the value
                        element.value = '';
                    @endif
                });
                // Disable all the labels
                Array
                    .prototype
                    .map
                    .call(label, element => element.classList.add('{{ config('action-forms.theme.disabled') }}'));
            }
            // Reset the counter if...
            __af_updateTextAreaCount(child);
        }
        // Reset the textarea count
        __af_updateTextAreaCount = function(child, count = 0, element = null) {
            // Remember we are working with a list of children.
            // The textarea allways has only one element.
            // So just take the first one (an unique) for fire an event.
            child[0].dispatchEvent(new CustomEvent('updatecounter', {detail: {value: count}}));
        }
    </script>
@endpush