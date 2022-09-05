{{-- Javascript: Depend On... --}}
<script>
    // For create and edit
    document
        .querySelector('[name={{ $dependOn }}]')
        .addEventListener('change', (parent) => {  
            // Get the container and the current element  
            let childContainer = document.querySelector('[data-container="{{ $uniqueKey }}"]');  
            let childElement = document.querySelector('[data-element="{{ $uniqueKey }}"]'); 
            window.__dependOn(parent.target, childContainer, childElement, @json($dependOnType), @json($value));
    });
    // For edit
    document
        .addEventListener('DOMContentLoaded', () => {  
            // Get the container and the current element  
            let childContainer = document.querySelector('[data-container="{{ $uniqueKey }}"]');  
            let childElement = document.querySelector('[data-element="{{ $uniqueKey }}"]'); 
            let parent = document.querySelector('[name="{{ $dependOn }}"]'); 
            window.__dependOn(parent, childContainer, childElement, @json($dependOnType), @json($value));
    })
</script>