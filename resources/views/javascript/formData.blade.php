{{-- Form field javascript --}}
@once('action-forms-scripts')
    <script defer $_key="{{ str()->uuid() }}">
        document.addEventListener('alpine:init', () => {
            Alpine.data('formData', (parent, conditional, value, valueEqual, type, databaseValue = null, currentElement) => ({
                parent: parent,
                conditional: conditional,
                value: value,
                valueEqueal: valueEqual,
                databaseValue: databaseValue,
                type: type,
                currentElement: currentElement,
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
                        return this.hasParent(parentField);
                    }
                },
                hasParent(parent) {
                    // Show or hide base on condition
                    if(this.conditional) {
                        this.visible = conditional ? true : false;
                        // If not visible, then reset values base on config setup
                        if(!this.visible) {
                            this.resetFieldValueBaseOnConfigSetup();
                        }
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
                parentIsNotCheckable(parent) {
                    // If the child has a value, we are in the edit action, so the field is enable
                    if(this.value) {
                        // Edit action -> checked or unchecked field base on database value
                        if(this.isCheckable(this.currentElement) && !this.isAnEmptyField(this.currentElement.dataset.value)) {
                            this.currentElement.checked = true;
                            this.currentElement.disabled = this.isAnEmptyField(this.currentElement.dataset.value) ? true : false;
                        }
                        // Default values for checkable element: create and edit
                        if(this.isCheckable(this.currentElement)) {
                            if(parent.value) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                        return false;
                    // We are not in the edit action
                    } else {
                        // If parent has a value and valueEqual is not defined, then enable child
                        if(parent.value && !this.valueEqual) {
                            return false;
                        }
                        // If parent has a value and is equal to valueEqual, then enable child
                        if(parent.value && this.valueEqual && parent.value === this.valueEqual) {
                            return false;
                        } 
                    }
                    // Check for children
                    if(this.hasChildren) {
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
                isAnEmptyField(value) {
                    if(value == null || value == undefined || value == false || value ==  '' || value == 0 || value == NaN) {
                        return true;
                    }
                    return false;
                }
            }))
        })
    </script>
@endonce