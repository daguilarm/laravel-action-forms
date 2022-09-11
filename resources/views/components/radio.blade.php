@props([
    'element' => $attributes->get('name'),
    'uniqueKey' => $uniqueKey,
    'css' => $css,
    'conditional' => $conditional,
    'width' => $width,
    'label' => $label,
    'id' => $id,
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType,
    'dependOnValue' => $dependOnValue,
    'helper' => $helper,
    'options' => $options,
    'position' => $position,
    'options' => $options,
    'value' => af__value($attributes, 'name', $data),
    'databaseValue' => $data->{$attributes->get('name')} ?? null,
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    {{-- Element container --}}
    <div 
        x-data="formData(
            '{{ $dependOn }}', 
            @json($conditional ?? true), 
            `{{ $value }}`, 
            '{{ $dependOnValue }}', 
            '{{ $dependOnType }}', 
            '{{ $databaseValue }}', 
            $refs.__{{ $uniqueKey }}
        )"
        id="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
        x-show="visible"
        :class="disabled ? disabledClass : ''"
    >
        {{-- Element --}}
        <div>
            {{-- Label  --}}
            @includeWhen($label, 'action-forms::elements.label')
            {{-- Radio elements --}}
            <div class="mt-2 mb-4 {{ $css->get('item') }}">
                {{-- Hack: only workd if there is an empty fiend --}}
                {{-- <input 
                    type="radio" 
                    data-element="{{ $uniqueKey }}"
                    data-parent="parent__{{ $element }}"
                    data-depend="depend_on__{{ $dependOn }}"
                    data-checked="{{ $checked ? 1 : 0 }}"
                    name="{{ $element }}"
                    class="hidden"
                > --}}
                {{-- Radio buttons --}}
                @foreach($options as $key => $text)
                    <div class="flex items-center mt-1">
                        {{-- Checkbox field --}}
                        <input 
                            type="radio"
                            x-ref="__{{ $uniqueKey }}"
                            x-on:click="enableOrDisableChildren($el)"
                            :disabled="disabled"
                            :value="value"
                            :checked="!isAnEmptyField(value) && value === databaseValue"
                            data-key="{{ $uniqueKey }}"
                            data-value="{{ $databaseValue }}"
                            data-parent="{{ $dependOn }}"
                            data-field="__{{ $uniqueKey }}"
                            data-equal="{{ $dependOnValue }}"
                            data-condition="{{ $conditional }}"
                            dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                            class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')" 
                            {{-- Native attributes --}}
                            {{ $attributes }} 
                        >
                        <span class="af_element_disabled_{{ $uniqueKey }} ml-2 text-gray-600">{{ $text }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Validation errors and Helper --}}
        @include('action-forms::elements.helper-and-validation')
    </div> {{-- /Element container --}}
@else 
    @include('action-forms::elements.show')
@endif {{-- /Form element container --}}