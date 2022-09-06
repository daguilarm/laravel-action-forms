{{-- Javascript: Depend On... --}}
<script>
    // For create and edit
    document
        .querySelector('[name={{ $dependOn }}]')
        .addEventListener('change', (parent) => {  
            window.__dependOn(parent.target, @json($dependOnType), @json($value), @json($uniqueKey));
    });
    // For edit
    document
        .addEventListener('DOMContentLoaded', () => {  
            // Get the container and the current element  
            let parent = document.querySelector('[name="{{ $dependOn }}"]'); 
            window.__dependOn(parent, @json($dependOnType), @json($value), @json($uniqueKey));
    })
</script>