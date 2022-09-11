{{-- Form field javascript --}}
@once('action-forms-scripts')
    <script defer $_key="{{ str()->uuid() }}">
        document.addEventListener('alpine:init', () => {
            Alpine.data('formData', (parent, conditional, value, valueEqual, type, databaseValue = null, currentElement) => ({
                // Set the values
                parent: parent,
                conditional: conditional,
                value: value ? value.replace(/(\r\n|\n|\r)/gm,"") : value, // Fixed multilines values
                valueEqual: valueEqual,
                databaseValue: databaseValue,
                type: type,
                currentElement: currentElement,
                disabled: false,
                visible: true,
                checked: databaseValue ? true : false,
                counterVisible: false,
                count: 0,
                disabledClass: '{{ config('action-forms.theme.disabled') }}',
                resetValuesOnDisabled: '{{ config('action-forms.reset_disabled') }}',
                // Init the component
                init() {
                    // Show or hide base on condition
                    if(!this.conditional) {
                        // this.visible = false;
                        this.disabled = true;
                        this.value = '';
                        // This way end here
                        return true;
                    // Rest of the cases
                    } else {
                        this.disabled = this.disableOrEnable(this.parent, this.value, this.valueEqual, this.conditional, false, currentElement);
                        this.visible = this.type === 'hidden' 
                            ? !this.disabled 
                            : true;
                    }
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
                // Get the element parent
                hasParent(parent) {
                    // Parent is checkable 
                    if(this.isCheckable(parent)) {
                        return this.parentIsCheckable(parent);
                    } 
                    // Parent is not checkable
                    return this.parentIsNotCheckable(parent);
                },
                // Parent element is not checkable
                parentIsNotCheckable(parent) {
                    // If the child has a value, we are in the edit action, so the field is enable
                    if(this.value) {
                        // Child is checkable
                        if(this.isCheckable(this.currentElement) && !this.isAnEmptyField(this.currentElement.dataset.value)) {
                            this.currentElement.checked = true;
                            this.currentElement.disabled = this.isAnEmptyField(this.currentElement.dataset.value) ? true : false;
                        }
                        // Default values for checkable element: create and edit
                        if(this.isCheckable(this.currentElement)) {
                            return parent.value ? false : true;
                        }
                        // Not checkable field
                        return false;
                    // We are not in the edit action
                    } else {
                        // If parent has a value and valueEqual is not defined, then enable the child
                        if(parent.value && !this.valueEqual) {
                            return false;
                        }
                        // If parent has a value and is equal to valueEqual, then enable the child
                        if(parent.value && this.valueEqual && parent.value === this.valueEqual) {
                            return false;
                        } 
                    }
                    // Check for children
                    if(this.hasChildren) {
                        this.enableOrDisableChildren(this.currentElement);
                    }
                    return true;
                },
                // Parent element is checkable
                parentIsCheckable(parent) {
                    // Is a radio button, so has multiples parent
                    if(this.isRadiable(parent)) {
                        // If radio button, then parent are multiples 
                        let isChecked = document.querySelectorAll('[name=' + this.parent + ']:checked');
                        // If parent is checked, the child is enabled.
                        if(isChecked[0]) {
                            return false;
                        }
                    // It is a checkbox 
                    } else {
                        // If parent is checked, the child is enabled.
                        if(parent.checked) {
                            return false;
                        }
                    }
                    // Child is disabled
                    // Check for children
                    if(this.hasChildren) {
                        this.enableOrDisableChildren(this.currentElement);
                    }
                    // Child maybe is reset
                    this.value = '';
                    // Child is disabled
                    return true;
                },
                // Enable or disable children
                enableOrDisableChildren(parent) {
                    let children = document.querySelectorAll('[data-parent=' + parent.name + ']');
                    // disable or enable all the children
                    children.forEach(element => {
                        // Get the container
                        let container = document.getElementById(element.dataset.key);
                        // If parent is checkable and is checked
                        if(this.isCheckable(parent) && parent.checked) {
                            this.enableChildren(parent, container, element);
                        // If parent is not checkable and has a value
                        } else if(!this.isCheckable(parent) && parent.value) {
                            this.enableChildren(parent, container, element);
                        // If parent has not value, then child element is disabled
                        } else {
                            container.classList.add(this.disabledClass);
                            element.disabled = true;
                            this.resetFieldValueBaseOnConfigSetup(element);
                        }
                    });
                },
                // Enable children
                enableChildren(parent, container, element) {
                    container.classList.remove(this.disabledClass);
                    element.disabled = false;
                    // Checkable children... 
                    if(this.isCheckable(element)) {
                        element.checked = element.databaseValue ? true : false;
                    }
                },
                // Reset values when disabled if this option is checked in config
                resetFieldValueBaseOnConfigSetup(element) {
                    // Reset values on disable or hide
                    if(this.resetValuesOnDisabled) {
                        element.value = '';
                        this.value = '';
                        element.checked = false;
                    }
                },
                // isAnEmptyField(value) -> it is on parent element -> form.blade.php
                // isCheckable(element) -> it is on parent element -> form.blade.php
                // isRadiable(element) -> it is on parent element -> form.blade.php
            }))
        })
    </script>
@endonce