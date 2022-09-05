{{-- Javascript: Depend On... --}}
@if($dependOn)
    <script>
        document
            .querySelector('[name={{ $dependOn }}]')
            .addEventListener('change', (element) => {  
                // Get the container and the current element  
                let currentContainer = document.querySelector('[data-container="{{ $uniqueKey }}"]');  
                let currentElement = document.querySelector('[data-element="{{ $uniqueKey }}"]');  
                
                // The element is active
                if(
                    // Input field
                    (element.target.value && element.target.getAttribute('type') !== 'checkbox') || 
                    // Checkbox
                    (element.target.getAttribute('type') === 'checkbox' && element.target.checked === true)
                ) {

                    @if($dependOnType === 'disabled') currentElement.disabled = false; @endif
                    @if($dependOnType === 'hidden') currentContainer.classList.remove('hidden'); @endif
                    console.log('error');

                // The element is disabled
                } else {

                    @if($dependOnType === 'disabled') currentElement.disabled = true; @endif
                    @if($dependOnType === 'hidden') currentContainer.classList.add('hidden'); @endif

                    // Reset value
                    currentElement.value = '';
                    currentElement.checked = false;

                    // Create an onchange evet
                    currentElement.dispatchEvent(new Event('change'));
                }
        })
    </script>
@endif

@if($dependOn && $viewAction === 'edit')
<script>
    document
        .addEventListener('DOMContentLoaded', (element) => {  
            // Get the container and the current element  
            let currentContainer = document.querySelector('[data-container="{{ $uniqueKey }}"]');  
            let currentElement = document.querySelector('[data-element="{{ $uniqueKey }}"]');   

            // The element is active
            if(currentElement.value || currentElement.checked === true) {

                @if($dependOnType === 'disabled') currentElement.disabled = false; @endif
                @if($dependOnType === 'hidden') currentContainer.classList.remove('hidden'); @endif
            
            // The element is disabled
            } else {

                @if($dependOnType === 'disabled') currentElement.disabled = true; @endif
                @if($dependOnType === 'hidden') currentContainer.classList.add('hidden'); @endif

                // Reset value
                currentElement.value = '';
                currentElement.checked = false;
            }
    })
</script>
@endif