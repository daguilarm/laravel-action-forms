@props([
    'conditional' => $conditional,
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType ?? 'disabled',
    'dependOnValue' => $dependOn ? true : false,
    'label' => $label,
    'width' => $width ?? 'w-full',
    'maxlength' => $maxlength,
    'rows' => $rows,
    'counter' => $counter,
    'element' => $attributes->get('name'),
    'helper' => $helper ?? null,
    'uniqueKey' => $uniqueKey,
    'css' => $css,
])

@php
    $value = old($element, $data->{$element} ?? null);
    $booleanValue = $value ? true : false;
@endphp

{{-- Show container --}}
@if($viewAction === 'show')
    @include('action-forms::elements.show')

{{-- Form element container --}}
@else 
    {{-- Element container --}}
    <div 
        x-data="{ 
            count: 0,
            conditional: '{{ $conditional }}',
            parent: '{{ $dependOn }}',
            init() {
                if(this.parent) {
                    this.count = $refs.t__{{ $element }}.value.length;
                    window.__af_dependOn(this.parent, '{{ $dependOnType }}', '{{ $booleanValue }}', '{{ $uniqueKey }}');
                } else {
                    this.count = $refs.t__{{ $element }}.value.length;
                }
            },
        }" 
        x-show="conditional"
        data-container="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
    >
        {{-- Add label --}}
        @includeWhen($label, 'action-forms::elements.label')

        <div>
            <textarea 
                x-ref="t__{{ $element }}" 
                x-on:keyup="count = $refs.t__{{ $element }}.value.length"
                @resetcounter="count = 0"
                data-element="{{ $uniqueKey }}"
                data-parent="parent__{{ $element }}"
                maxlength="{{ $maxlength }}"
                rows="{{ $rows }}"
                dusk="form-textarea-{{ $attributes->get('id') ?? $element }}"
                class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')" 
                {{-- Native attributes --}}
                {{ $attributes }} 
            >{{ trim($value) }}</textarea>
        </div>

        {{-- Validation errors and Helper --}}
        @include('action-forms::elements.helper-and-validation')

        {{-- Chars counter --}}
        @includeWhen($counter, 'action-forms::elements.counter')

    </div> {{-- /Element container --}}

@endif 

{{-- Push Javascript: Depend On... --}}
@includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on.onchange')
