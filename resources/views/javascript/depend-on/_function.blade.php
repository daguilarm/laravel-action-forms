<script>
    window.__dependOn = function(parent, type, value, key) {
        // Get the container and the current element  
        let childContainer = document.querySelector('[data-container="' + key + '"]');  
        let childElement = document.querySelector('[data-element="' + key + '"]'); 
        let label = document.getElementById('label-' + key);
        // Checkbox condition for edit action.
        // If parent has a value and the child has not, the field can be checked...
        if(childElement.getAttribute('type') === 'checkbox' && value <= 0) {
            childElement.checked = false;
        } 
        // The element is active
        if(parent.value && parent.getAttribute('type') !== 'checkbox') {
            // Enable elements
            if(type === 'disabled') {
                childElement.disabled = false;
                label.classList.remove('opacity-50');
            }
            if(type === 'hidden') childContainer.classList.remove('hidden');
        
        } else if(parent.getAttribute('type') === 'checkbox' && parent.checked === true) {
            // Enable elements
            if(type === 'disabled') {
                childElement.disabled = false;
                label.classList.remove('opacity-50');
            }
            if(type === 'hidden') childContainer.classList.remove('hidden');
        
        // The element is disabled
        } else {
            // Disable elements
            if(type === 'disabled') {
                childElement.disabled = true;
                label.classList.add('opacity-50');
            }
            if(type === 'hidden') childContainer.classList.add('hidden');
            // Reset value
            childElement.value = '';
            childElement.checked = false;
            // Create an onchange evet
            childElement.dispatchEvent(new Event('change'));
        }
    }
</script>