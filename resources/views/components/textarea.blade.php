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

{{-- Include: javascript + show view --}}
@include('action-forms::component')

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    {{-- Element container --}}
    <div 
        x-data="{ 
            count: 0,
            conditional: '{{ $conditional }}',
            parent: '{{ $dependOn }}',
            counterVisible: false,
            init() {
                if(this.parent) {
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
            {{-- Texarea fuekd --}}
            <textarea 
                x-ref="t__{{ $element }}" 
                x-on:keyup="count = $refs.t__{{ $element }}.value.length"
                x-on:updatecounter="count = $event.detail.value"
                x-on:focus="$dispatch('updatecounter', {value: $refs.t__{{ $element }}.value.length}); counterVisible = true;"
                x-on:click.outside="counterVisible = false"
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
        @if($counter)
            <div 
                class="{{ $css->get('counter') }}"
                x-show="counterVisible"
            >
                <span x-html="count"></span> / <span x-html="$refs.t__{{ $element }}.maxLength"></span>
            </div>
        @endif
    </div> {{-- /Element container --}}
@endif 
