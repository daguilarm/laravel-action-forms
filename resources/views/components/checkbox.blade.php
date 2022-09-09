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
    'value' => $value,
])

@php
    $value = old($element, $data->{$element} ?? null);
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
                        '{{ $dependOnValue }}', 
                        '{{ $checked }}', 
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
                    type="checkbox" 
                    data-element="{{ $uniqueKey }}"
                    data-parent="parent__{{ $element }}"
                    data-depend="depend_on__{{ $dependOn }}"
                    data-value="{{ $value }}"
                    data-checked="{{ $checked ? 1 : 0 }}"
                    x-ref="__{{ $element }}"
                    class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')"
                    {{ $checked ? 'checked' : '' }}
                    {{ $attributes }}
                    :value="$el.checked ? $el.dataset.value : null"
                    @click="console.log($el.value)"
                >
                {{-- Label --}}
                @includeWhen($label, 'action-forms::elements.label')
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@endif {{-- /Form-element container --}}