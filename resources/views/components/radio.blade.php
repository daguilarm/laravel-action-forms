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
    $booleanValue = $value ? true : false;
    $checked = $value ? true : false;
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
            <div class="mt-1.5 mb-4 {{ $position === 'vertical' ? 'block' : 'flex items-center' }}">
                {{-- Label --}}
                @includeWhen($label, 'action-forms::elements.label')
                {{-- Radio elements --}}
                @foreach($options as $key => $text)
                    <div class="flex">
                        {{-- Checkbox field --}}
                        <input 
                            type="checkbox" 
                            data-element="{{ $uniqueKey }}"
                            data-parent="parent__{{ $element }}"
                            x-ref="{{ $key }}__{{ $element }}"
                            class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')"
                            value="{{ $key }}"
                            id="{{ $element }}_{{ $key }}"
                            name="{{ $element }}"
                            {{ $checked ? 'checked' : '' }}
                        >
                        <span class="af_element_disabled_{{ $uniqueKey }} ml-2">{{ $text }}</span>
                    </div>
                @endforeach
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@endif {{-- /Form-element container --}}