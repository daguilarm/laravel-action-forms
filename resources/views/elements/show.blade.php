<div 
    class="{{ config('action-forms.theme.show.container') }}" 
    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
>
    {{-- Label --}}
    <div class="{{ config('action-forms.theme.show.label') }}">
        {{ $label }}
    </div>
                
    {{-- Show data --}}
    <div class="{{ config('action-forms.theme.show.data') }}">
        {{ ($value <= 0 || is_null($value) || $value === '') ? config('action-forms.theme.empty-field') : $value }} 
        
        {{-- Addon after --}}
        @isset($after)
            <span class="{{ config('action-forms.theme.show.after') }}">{{ $after }}</span>
        @endisset
    </div>
</div> 