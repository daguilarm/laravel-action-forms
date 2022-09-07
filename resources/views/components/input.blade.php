@props([
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType ?? 'disabled',
    'dependOnValue' => $dependOn ? true : false,
    'after' => $after,
    'before' => $before,
    'addons' => $addons,
    'label' => $label,
    'width' => $width ?? 'w-full',
    'element' => $attributes->get('name'),
    'helper' => $helper ?? null,
    'uniqueKey' => $uniqueKey,
    'css' => $css,
])

@php
    $value = old($element, $data->{$element} ?? null);
@endphp

{{-- Show container --}}
@if($viewAction === 'show')
    @include('action-forms::elements.show')

{{-- Form element container --}}
@else 
    <div 
        x-data="{
            {{-- Get the parent --}}
            @if($dependOn)
                parent: document.querySelector('[name={{ $dependOn }}]'),
            @else 
                parent: null,
            @endif
            value: '{{ $value }}',
            {{ $element }}: {{ $dependOn ? 'true' : 'false' }},
        }"
        class="{{ $width }} {{ $cssElement }}"
    >
        {{-- Add label --}}
        @includeWhen($label, 'action-forms::elements.label')
        
        {{-- Element container --}}
        <div>
            <div class="flex mt-1.5">

                {{-- Addon before --}}
                @includeWhen($before, 'action-forms::elements.addon-before')

                {{-- Input field --}}
                <input 
                    @if($dependOn)
                        x-bind:disabled="this.{{ $dependOn }} ? true : false"
                        x-on:onchange="this.{{ $element }} = $event.detail.{{ $element }}"
                    @endif
                    x-ref="{{ $element }}"
                    x-on:keydown="$dispatch('onchange', { {{ $element }}: $refs.{{ $element }}.value ? true : false})"
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="{{ $css->get('base') }} {{ $addons }} @include('action-forms::elements.validation-highlight')" 
                    value="{{ $value }}"

                    {{-- Native attributes --}}
                    {{ $attributes }} 

                />

                {{-- Addon after --}}
                @includeWhen($after, 'action-forms::elements.addon-after')
            </div>

            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>

    </div> {{-- /Element container --}}

@endif {{-- /Form element container --}}