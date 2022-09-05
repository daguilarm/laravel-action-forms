<div 
    class="w-full flex items-center p-3 border-b border-gray-100 text-sm" 
    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
>
    {{-- Label --}}
    <div class="w-1/4 text-gray-400">
        {{ $label }}
    </div>
                
    {{-- Show container --}}
    <div class="w-3/4 text-gray-500 font-semibold">
        {{ ($value <= 0 || is_null($value) || $value === '') ? config('action-forms.theme.empty-field') : $value }}
    </div>

    {{-- Addon after --}}
    {{-- @includeWhen($after, 'action-forms::elements.addon-after') --}}
</div> 