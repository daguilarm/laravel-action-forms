{{-- Javascript: Depend On... --}}
@once('action-forms-scripts')
    <script $_key="{{ str()->uuid() }}">
        // Get the paremeter from config (reset values on disable or hide)
        window.af__resetValues = Boolean('{{ config('action-forms.reset_disabled') }}');
        // Disable or enable element
        window.af__disableOrEnable = function(parent, value, valueEqual, conditional, hasChildren, currentElement) {
            let disabled = true;
            // If field has not parent, then visible
            if(!parent) {
                disabled = false;
            // If field has parent, then start the magic!
            } else {
                // Show or hide base on condition
                if(conditional) {
                    visible = conditional ? true : false;
                    disabled = ! visible;
                // Edit action
                } else if(value) {
                    return false;
                // With no condition
                } else {
                    // Get all the parents
                    let fieldParent = document.querySelectorAll('[data-parent=' + parent.name + ']');
                    // One by one
                    [].map.call(fieldParent, element => {
                        // If parent is a checkbox or a radio button
                        if(element.getAttribute('type') === 'checkbox' || element.getAttribute('type') === 'radio') {
                            // If parent is checked, then enable child
                            if(element.checked) {
                                disabled = false;
                            }
                        // Input, select and textareas fields
                        } else {
                            // If parent has a value and valueEqual is not defined, then enable child
                            if(element.value && !valueEqual) {
                                disabled = false;
                            }
                            // If parent has a value and is equal to valueEqual, then enable child
                            if(element.value && valueEqual && element.value === valueEqual) {
                                disabled = false;
                            } 
                        }
                    });
                }
            }
            // Check for children
            if(hasChildren) {
                window.af__enableOrDisableChildren(currentElement);
            }
            // Send all the magic
            return disabled;
        }
        // Disable or enable children
        window.af__enableOrDisableChildren = function(parent) {
            let children = document.querySelectorAll('[data-parent=' + parent.name + ']');
            // disable or enable all the children
            [].map.call(children, element => {
                let container = document.getElementById(element.dataset.key);
                window.af__reset_element(container, element);
            });
        },
        // Reset element
        window.af__reset_element = function(container, element) {
            // Reset container
            container.visible = element.value ? false : true;
            container.classList.remove('{{ config('action-forms.theme.disabled') }}')
            // Reset element and set default values
            element.disabled = element.value ? true : false;
            element.checked = element.databaseValue ? true : false;
            // Reset values on disable or hide
            if(window.af__resetValues) {
                element.value = '';
                element.checked = false;
            }
        }
        // // Textarea: counter of words
        // window.af__updateTextarea = function (element) {
        //     // Dispatch event for update value in textarea
        //     $dispatch('updatecounter', {
        //         value: element.value.length
        //     }); 
        //     // Show counter
        //     counterVisible = true;
        // }
    </script>
@endonce