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
    'helper' => $helper,
    'options' => $options,
    'position' => $position,
    'options' => $options,
])

@php
    $value = old($element, $data->{$element} ?? null);
    $booleanValue = $value ? true : false;;
@endphp

{{-- Include: javascript + show view --}}
@include('action-forms::component')

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    {{-- Element container --}}
    <div 
        x-data="{
            conditional: '{{ $conditional }}',
            parent: '{{ $dependOn }}',
            init() {
                if(this.parent) {
                    window.__af_dependOn(
                        '{{ $dependOn }}', 
                        '{{ $dependOnType }}', 
                        '{{ $booleanValue }}', 
                        '{{ $uniqueKey }}'
                    );
                }
            },
        }"
        x-show="conditional"
        data-container="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
    >
        {{-- Element --}}
        <div>
            {{-- Label  --}}
            @includeWhen($label, 'action-forms::elements.label')
            {{-- Radio elements --}}
            <div class="mt-2 mb-4 {{ $css->get('item') }}">
                @foreach($options as $key => $text)
                    <div class="flex items-center mt-1">
                        {{-- Checkbox field --}}
                        <input 
                            type="radio" 
                            data-element="{{ $uniqueKey }}"
                            data-parent="parent__{{ $element }}"
                            x-ref="{{ $key }}__{{ $element }}"
                            class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')"
                            value="{{ $key }}"
                            name="{{ $element }}"
                            {{ $value === $key ? 'checked' : '' }}
                        >
                        <span class="af_element_disabled_{{ $uniqueKey }} ml-2 text-gray-600">{{ $text }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Validation errors and Helper --}}
        @include('action-forms::elements.helper-and-validation')
    </div> {{-- /Element container --}}
@endif {{-- /Form-element container --}}