<script>
    window.__dependOn = function(parent, childContainer, childElement, type, value) {
        // Get the container and the current element  
        let inputFieldBoolean = parent.value && parent.getAttribute('type') !== 'checkbox';
        let checkboFieldBooelan = parent.getAttribute('type') === 'checkbox' && parent.checked === true && value > 0;
        // Checkbox condition for edit action.
        // If parent has a value and the child has not, the field can be checked...
        if(childElement.getAttribute('type') === 'checkbox' && value <= 0) {
            childElement.checked = false;
        } 
        // The element is active
        if(inputFieldBoolean || checkboFieldBooelan) {
            // Enable elements
            if(type === 'disabled') childElement.disabled = false;
            if(type === 'hidden') childContainer.classList.remove('hidden');
        // The element is disabled
        } else {
            // Disable elements
            if(type === 'disabled') childElement.disabled = true;
            if(type === 'hidden') childContainer.classList.add('hidden');
            // Reset value
            childElement.value = '';
            childElement.checked = false;
            // Create an onchange evet
            childElement.dispatchEvent(new Event('change'));
        }
    }
</script>