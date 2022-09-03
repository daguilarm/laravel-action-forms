{{-- Addon before --}}
@if($before)
    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 {{ config('action-forms.theme.addons') }} @error($element) border-red-500 @else border-gray-200 @enderror">
        {{ $before }}
    </span>
@endif 