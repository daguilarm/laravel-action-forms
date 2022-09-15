@props([
    'element' => $attributes->get('name'),
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    <div 
        x-data="
            formElement(
                '{{ $dependOn }}', 
                Boolean(@json($conditional ?? true)), 
                ``, 
                '', 
                'disabled', 
                databaseValue = null, 
                $refs.__{{ $uniqueKey }}
            )
        "
        id="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
        x-show="visible"
        :class="disabled ? disabledClass : ''"
    >
        {{-- Add label --}}
        @includeWhen($label, 'action-forms::elements.label')
        
        {{-- Element container --}}
        <div>
            <div class="flex mt-1.5">
                {{-- Select field --}}
                <input 
                    type="file" 
                    x-ref="__{{ $uniqueKey }}"
                    :disabled="disabled"
                    data-key="{{ $uniqueKey }}"
                    data-parent="{{ $dependOn }}"
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')" 
                    {{-- Native attributes --}}
                    {{ $attributes }} 
                />
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@else 
    @include('action-forms::elements.show')
@endif {{-- /Form element container --}}