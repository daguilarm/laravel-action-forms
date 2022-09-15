@props([
    'element' => $attributes->get('name'),
    'value' => af__value($attributes, 'name', $data),
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
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
        {{-- Add label --}}
        @includeWhen($label, 'action-forms::elements.label')
        
        {{-- Element container --}}
        <div x-data="            
            formSelect(
                '{{ $element }}',
                '{{ $comboboxFrom }}', 
                '{{ $resultKey }}', 
                '{{ $resultValue}}', 
                {{ json_encode($fromArray) }},
                '{{ $fromUrl }}'
            )
        ">
            <div class="flex mt-1.5">
                {{-- Select field --}}
                <select 
                    x-ref="__{{ $uniqueKey }}"
                    x-on:change="enableOrDisableChildren($el)"
                    :disabled="disabled"
                    data-key="{{ $uniqueKey }}"
                    data-value="{{ $value }}"
                    data-parent="{{ $dependOn }}"
                    data-equal="{{ $dependOnValue }}"
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')" 
                    {{-- Native attributes --}}
                    {{ $attributes }} 
                >
                    <option></option>
                    <template x-for="[key, result] in Object.entries(results)">
                        <option 
                            x-text="result[resultValue]"
                            :value="result[resultKey]"
                            :key="{{ str()->uuid() }}"
                        ></option>
                    </template>
                </select>
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@else 
    @include('action-forms::elements.show')
@endif {{-- /Form element container --}}

{{-- Javascript: form select --}}
@includeWhen($viewAction !== 'show', 'action-forms::javascript.select-js')