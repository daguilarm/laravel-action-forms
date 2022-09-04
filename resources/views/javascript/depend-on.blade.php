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
                if(element.target.value) {

                    @if($dependOnType === 'disabled') currentElement.disabled = false; @endif
                    @if($dependOnType === 'hidden') currentContainer.classList.remove('hidden'); @endif
                
                // The element is disabled
                } else {

                    @if($dependOnType === 'disabled') currentElement.disabled = true; @endif
                    @if($dependOnType === 'hidden') currentContainer.classList.add('hidden'); @endif

                    // Reset value
                    currentElement.value = '';

                    // Create an onchange evet
                    currentElement.dispatchEvent(new Event('change'));
                }
        })
    </script>
@endif