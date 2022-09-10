{{-- Form field javascript --}}
@once('action-forms-scripts')
    <script $_key="{{ str()->uuid() }}">
        document.addEventListener('alpine:init', () => {
            Alpine.data('formData', (parent, conditional, value, valueEqual, type, databaseValue = null, currentElement) => ({
                parent: parent,
                conditional: conditional,
                value: value,
                valueEqueal: valueEqual,
                databaseValue: databaseValue,
                type: type,
                disabled: false,
                visible: true,
                checked: databaseValue ? true : false,
                disabledClass: '{{ config('action-forms.theme.disabled') }}',
                resetValuesOnDisabled: '{{ config('action-forms.reset_disabled') }}',
                init() {
                    this.disabled = this.disableOrEnable(this.parent, this.value, this.valueEqual, this.conditional, false, currentElement);
                    this.visible = this.type === 'hidden' 
                        ? !this.disabled 
                        : true;
                },
                // Disable or enable fields
                disableOrEnable(parent, value, valueEqual, conditional, hasChildren, currentElement, disabled = true) {
                    // If field has not parent, then the field is enable
                    if(!parent) {
                        return false;
                    // If field has parent, then start the magic!
                    } else {
                        // Set the parent element 
                        let parentField = document.querySelector('[name=' + parent + ']');
                        return this.hasParent(conditional, parentField);
                    }
                },
                hasParent(conditional, parent) {
                    // Show or hide base on condition
                    if(conditional) {
                        this.visible = conditional ? true : false;
                        return !visible;
                    // With no condition
                    } else { 
                        // Parent is checkable 
                        if(this.isCheckable(parent)) {
                            return this.parentIsCheckable(parent);
                        } 
                        // Parent is not checkable
                        return this.parentIsNotCheckable(parent);
                    }
                },
                isCheckable(element) {
                    return element.getAttribute('type') === 'checkbox' || element.getAttribute('type') === 'radio';
                },
                parentIsNotCheckable(parent, value, hasChildren, currentElement) {
                    // If the child has a value, we are in the edit action, so the field is enable
                    if(value) {
                        return false;
                    // We are not in the edit action
                    } else {
                        // If parent has a value and valueEqual is not defined, then enable child
                        if(parent.value && !valueEqual) {
                            return false;
                        }
                        // If parent has a value and is equal to valueEqual, then enable child
                        if(parent.value && valueEqual && parent.value === valueEqual) {
                            return false;
                        } 
                    }
                    // Check for children
                    if(hasChildren) {
                        this.enableOrDisableChildren(currentElement);
                    }

                    return true;
                },
                parentIsCheckable() {

                },
                enableOrDisableChildren(parent) {
                    let children = document.querySelectorAll('[data-parent=' + parent.name + ']');
                    // disable or enable all the children
                    children.forEach(element => {
                        // Get the container
                        let container = document.getElementById(element.dataset.key);
                        // If parent has a value, then the child element is enable
                        if(parent.value) {
                            container.classList.remove(this.disabledClass);
                            element.disabled = false;
                            // Checkable children... 
                            element.checked = element.databaseValue ? true : false;
                        // Child element is disabled
                        } else {
                            container.classList.add(this.disabledClass);
                            element.disabled = true;
                            this.resetFieldValueBaseOnConfigSetup(element);
                        }
                    });
                },
                resetFieldValueBaseOnConfigSetup(element) {
                    // Reset values on disable or hide
                    if(this.resetValuesOnDisabled) {
                        element.value = '';
                        element.checked = false;
                    }
                },
            }))
        })
    </script>
@endonce