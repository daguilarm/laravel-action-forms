{{-- Form field javascript --}}
@push('action-forms-scripts')
    <script defer $_key="{{ str()->uuid() }}">
        document.addEventListener('alpine:init', () => {
            // Define the form element
            Alpine.data('formElement', (parent, conditional, value, valueEqual, type, databaseValue = null, currentElement) => ({
                // Set the default values for the component
                disabled: false,
                visible: true,
                currentElement: currentElement,
                parent: parent,
                checked: databaseValue ? true : false,
                value: value ? value.replace(/(\r\n|\n|\r)/gm,"") : value, // Fixed multilines values
                databaseValue: databaseValue,
                conditional: conditional,
                // Dependant elements
                dependOnType: type,
                dependOnValue: valueEqual,
                // Tailwind classes
                disabledClass: '{{ config('action-forms.theme.disabled') }}',
                resetValuesOnDisabled: '{{ config('action-forms.reset_disabled') }}',
                // Textarea
                counterVisible: false,
                count: 0,
                // Init the component for the element
                init() {
                    // Show or hide the current element base on a condition
                    // The condition will be boolean so... 
                    // If condition is false
                    if(!this.conditional) {
                        // this.visible = false;
                        this.disabled = true;
                        this.visible = this.visibility();
                        // Current element maybe is reset
                        if(this.resetValuesOnDisabled) {
                            this.value = '';
                        }
                        // This way end here
                        return;
                    } 
                    // Set init values for disabled and visible
                    // Check if the current element must be disabled
                    this.disabled = this.disableOrEnable(this.parent, this.value, this.dependOnValue, this.conditional, false, currentElement);
                    // Check if the current element must be visble
                    this.visible = this.visibility();
                },
                // Define the visibility of the current element
                // Will check for dependant type (in this case hidden)
                visibility() {
                    return this.dependOnType === 'hidden' 
                        ? !this.disabled 
                        : true;
                },
                // Disable or enable fields base on parent status
                disableOrEnable(parent, value, dependOnValue, conditional, hasChildren, currentElement, disabled = true) {
                    // If the current element has not parent element...
                    // Then the current element is enable
                    if(!parent) {
                        return false;
                    } 
                    // If the current element has a parent...
                    // Then will get the parent element
                    let parentField = document.querySelector('[name=' + parent + ']');
                    // Will decide if the current element must be enable or disabled
                    // This will be decided base on if this element has a parent
                    return this.hasParent(parentField);
                },
                // If the current element has a parent...
                // We have to evaluate the parent
                hasParent(parent) {
                    // If parent is a checkable element...
                    if(this.isCheckable(parent)) {
                        return this.parentIsCheckable(parent);
                    } 
                    // If parent is not a checkable element...
                    return this.parentIsNotCheckable(parent);
                },
                // Will evaluate the parent
                // If the parent element is not checkable...
                parentIsNotCheckable(parent) {
                    // If the child element has a value, the field must be enabled
                    if(this.value) {
                        // Action view: create 
                        // Current element is checkable and has no value
                        // Will be disabled or enabled base on the parent value
                        if(this.isCheckable(this.currentElement) && this.isAnEmptyField(this.currentElement.dataset.value)) {
                            return parent.value ? false : true;
                        }
                        // Action view: edit 
                        // The current element is checkable and has a valid value
                        if(this.isCheckable(this.currentElement) && !this.isAnEmptyField(this.currentElement.dataset.value)) {
                            this.currentElement.checked = true;
                            this.currentElement.disabled = this.isAnEmptyField(this.currentElement.dataset.value) ? true : false;
                        }
                        // Action view: edit 
                        // Not checkable field
                        // Current element will be enabled
                        return false;

                    // If the current element has not a value
                    } else {
                        // If parent element has a value...
                        // And dependOnValue is not defined (we just want any value)...
                        // Then the child element will be enabled
                        if(parent.value && !this.dependOnValue) {
                            return false;
                        }
                        // If parent has a value...
                        // And this value is equal to dependOnValue...
                        // Then the child element will be also enabled
                        if(parent.value && this.dependOnValue && parent.value === this.dependOnValue) {
                            return false;
                        } 
                    }
                    // Now will check if the current element has children 
                    // Then will enable or disable the children
                    if(this.hasChildren) {
                        this.enableOrDisableChildren(this.currentElement);
                    }
                    // Will desabled the element by default
                    return true;
                },
                // Will evaluate the parent
                // If the parent element is checkable
                parentIsCheckable(parent) {
                    // If the parent is a radio button... 
                    // Then the current element will have multiples parents
                    if(this.isRadioButton(parent)) {
                        // Get all the checked parents
                        // We only need one checked parent to enable the element...
                        // So we only need to check if the first element exits
                        if(this.ifParentIsRadiobuttonGetTheCheckedElement(parent)) {
                            this.enableOrDisableChildren(parent);
                            return false;
                        }
                    // The parent element is a checkbox 
                    } else {
                        // If parent is checked... 
                        // The child is enabled
                        if(parent.checked) {
                            this.enableOrDisableChildren(parent);
                            return false;
                        }
                    }
                    // Child maybe is reset
                    if(this.resetValuesOnDisabled) {
                        this.value = '';
                    }
                    // Child element is disabled
                    return true;
                },
                // If the parent element is a radio button 
                // Then has multiples parents 
                // Get the checked radio button... will be the first element.
                ifParentIsRadiobuttonGetTheCheckedElement(parent) {
                    return document.querySelectorAll('[name=' + parent.name + ']:checked')[0];
                },
                // Enable or disable children elements
                enableOrDisableChildren(parent) {
                    let children = document.querySelectorAll('[data-parent=' + parent.name + ']');
                    // Disable or enable all the children elements
                    children.forEach(element => {
                        // Get the current element container
                        let container = document.getElementById(element.dataset.key);
                        // If parent element is a radio button
                        if(this.isRadioButton(parent)) {
                            // Get all the checked parents
                            // We only need one checked parent to enable the element...
                            // So we only need to check if the first element exits
                            if(this.ifParentIsRadiobuttonGetTheCheckedElement(parent)) {
                                this.enableChildren(parent, container, element);
                            }
                        // If parent element is a checkbox
                        // If parent element is checked
                        } else if(this.isCheckbox(parent) && parent.checked) {
                            this.enableChildren(parent, container, element);
                        // If parent element is not a checkbox
                        // If parent element has a value
                        } else if(!this.isCheckbox(parent) && parent.value) {
                            this.enableChildren(parent, container, element);
                        // If the parent element has no value... 
                        // Then the child element is disabled
                        } else {
                            container.classList.add(this.disabledClass);
                            element.disabled = true;
                            this.resetFieldValueBaseOnConfigSetup(element);
                        }
                    });
                },
                // Enable children elements
                enableChildren(parent, container, element) {
                    // Enable container
                    container.classList.remove(this.disabledClass);
                    // Enable element
                    element.disabled = false;
                    // Children is a radio button
                    // Will check for a children value
                    if(this.isRadioButton(element) && !this.isAnEmptyField(element.dataset.value)) {
                        element.checked = element.dataset.value === this.value  ? true : false;
                    }
                    // Children is a checkbox and has a value
                    // Will check for a children value
                    if(this.isCheckbox(element) && !this.isAnEmptyField(element.dataset.value)) {
                        element.checked = element.dataset.value  ? true : false;
                    }
                },
                // Reset values 
                // Base on config options
                resetFieldValueBaseOnConfigSetup(element) {
                    // Reset element
                    if(this.resetValuesOnDisabled) {
                        element.value = '';
                        this.value = '';
                        element.checked = false;
                    }
                },
                // isAnEmptyField(value) -> it is on parent element -> form.blade.php
                // isCheckable(element) -> it is on parent element -> form.blade.php
                // isRadioButton(element) -> it is on parent element -> form.blade.php
            }))
        })
    </script>
@endpush