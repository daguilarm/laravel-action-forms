{{-- Javascript: Depend On... --}}
@push('action-forms-scripts')
    <script $_key="{{ str()->uuid() }}">
        document
            .querySelector('[name={{ $dependOn }}]')
            .addEventListener('change', () => {  
                __af_dependOn(@json($dependOn), @json($dependOnType), @json($value ? true : false), @json($dependOnValue), @json($uniqueKey));
        });
    </script>
@endpush