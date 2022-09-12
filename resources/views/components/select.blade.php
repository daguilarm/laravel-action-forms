@props([
    'element' => $attributes->get('name'),
    'uniqueKey' => $uniqueKey,
    'css' => $css,
    'conditional' => $conditional,
    'width' => $width,
    'label' => $label,
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType,
    'dependOnValue' => $dependOnValue,
    'helper' => $helper,
    'value' => af__value($attributes, 'name', $data),
    'default' => $default,
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    <div 
        x-data="formData(
            '{{ $dependOn }}', 
            @json($conditional ?? true), 
            `{{ $value }}`, 
            '{{ $dependOnValue }}', 
            '{{ $dependOnType }}', 
            databaseValue = null, 
            $refs.__{{ $uniqueKey }}
        )"
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
                <select 
                    x-ref="__{{ $uniqueKey }}"
                    x-on:change="enableOrDisableChildren($el)"
                    :disabled="disabled"
                    data-key="{{ $uniqueKey }}"
                    data-value="{{ $value }}"
                    data-parent="{{ $dependOn }}"
                    data-field="__{{ $uniqueKey }}"
                    data-equal="{{ $dependOnValue }}"
                    data-condition="{{ $conditional }}"
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')" 
                    {{-- Native attributes --}}
                    {{ $attributes }} 
                >
                    <option></option>
                    @foreach($options as $key => $value)
                        <option value="{{ $key }}" {{ af__option_default($key, $default) }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@else 
    @include('action-forms::elements.show')
@endif {{-- /Form element container --}}