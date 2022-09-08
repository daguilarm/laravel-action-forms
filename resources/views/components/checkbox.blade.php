@props([
    'element' => $attributes->get('name'),
    'uniqueKey' => $uniqueKey,
    'css' => $css,
    'conditional' => $conditional,
    'width' => $width,
    'label' => $label,
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType,
    'helper' => $helper,
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
            <div class="flex items-center mt-1.5 mb-4">
                {{-- Checkbox field --}}
                <input 
                    type="radio" 
                    data-element="{{ $uniqueKey }}"
                    data-parent="parent__{{ $element }}"
                    x-ref="__{{ $element }}"
                    class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')"
                    value="{{ $value }}"
                    {{ $checked ? 'checked' : '' }}
                    {{ $attributes }}
                >
                {{-- Label --}}
                @includeWhen($label, 'action-forms::elements.label')
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@endif {{-- /Form-element container --}}