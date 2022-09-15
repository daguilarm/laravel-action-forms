@props([
    'element' => $attributes->get('name'),
    'value' => af__value($attributes, 'name', $data),
    'databaseValue' => $data->{$attributes->get('name')} ?? null,
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    {{-- Element container --}}
    <div 
        x-data="
            formElement(
                '{{ $dependOn }}', 
                @json($conditional ?? true), 
                `{{ $value }}`, 
                '{{ $dependOnValue }}', 
                '{{ $dependOnType }}', 
                databaseValue = null, 
                $refs.__{{ $uniqueKey }}
            )
        "
        id="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
        x-show="visible"
        :class="disabled ? disabledClass : ''"
    >
        {{-- Element --}}
        <div>
            <div class="flex items-center mt-1.5 mb-4">
                {{-- Checkbox field --}}
                <input 
                    type="checkbox"
                    x-ref="__{{ $uniqueKey }}"
                    x-on:click="enableOrDisableChildren($el)"
                    :disabled="disabled"
                    :checked="checked"
                    :value="value"
                    data-key="{{ $uniqueKey }}"
                    data-value="{{ $databaseValue }}"
                    data-parent="{{ $dependOn }}"
                    data-equal="{{ $dependOnValue }}"
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')" 
                    {{-- Native attributes --}}
                    {{ $attributes }} 
                >
                {{-- Label --}}
                @includeWhen($label, 'action-forms::elements.label')
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@else 
    @include('action-forms::elements.show')
@endif {{-- /Form element container --}}