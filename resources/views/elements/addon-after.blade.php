{{-- Addon after --}}
@if($after)
    <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 {{ config('action-forms.theme.addons') }} @error($element) border-red-500 @else border-gray-200 @enderror">
        {{ $after }}
    </span>
@endif 