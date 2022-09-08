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

        {{-- As boolean --}}
        @if(isset($asBoolean) && $asBoolean)
            <div class="w-4 h-4 rounded-full {{ $value ? 'bg-green-500' : 'bg-gray-400' }}"></div>
        {{-- Regular output --}}
        @else
            {{ ($value <= 0 || is_null($value) || $value === '') ? config('action-forms.theme.empty-field') : $value }} 
        @endif
        
        {{-- Addon after --}}
        @if($after)
            <span class="{{ config('action-forms.theme.show.after') }}">{{ $after }}</span>
        @endif
    </div>
</div> 