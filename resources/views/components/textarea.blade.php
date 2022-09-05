@props([
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
@endphp

{{-- Element container --}}
<div 
    data-container="{{ $uniqueKey }}"
    class="block {{ $width }} mb-6"

    {{-- DependOn Condition: hidden --}}
    @includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on.hidden')
>
    {{-- Add label --}}
    @includeWhen($label, 'action-forms::elements.label')

    {{-- Element --}}
    <div class="mt-1.5">

        {{-- Text version --}}
        @if($viewAction === 'show')
            <div class="flex">
                <div 
                    dusk="form-textarea-{{ $attributes->get('id') ?? $element }}"
                    class="w-full p-2 {{ config('action-forms.theme.input.text') }} {{ config('action-forms.theme.input.bg') }} {{ config('action-forms.theme::input.shadow') }}"
                >                    
                    {{ $data->{$element} }}
                </div>
            </div>

        {{-- Form version --}}
        @else
            <div                 
                x-data="{ count: 0 }" 
                x-init="count = $refs.{{ $element }}.value.length"
            >
                <div class="flex">
                    <textarea 
                        x-ref="{{ $element }}" 
                        x-on:keyup="count = $refs.{{ $element }}.value.length"
                        data-element="{{ $uniqueKey }}"
                        maxlength="{{ $maxlength }}"
                        rows="{{ $rows }}"
                        dusk="form-textarea-{{ $attributes->get('id') ?? $element }}"
                        class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')" 
                        
                        {{-- DependOn Conditions: Disabled --}}
                        @includeWhen($dependOnValue && $dependOnType, 'action-forms::javascript.depend-on.disabled')
                        
                        {{-- Native attributes --}}
                        {{ $attributes }} 
                    >{{ trim($value) }}</textarea>
                </div>

                {{-- Validation errors and Helper --}}
                @include('action-forms::elements.helper-and-validation')

                {{-- Chars counter --}}
                @includeWhen($counter, 'action-forms::elements.counter')
            </div> 

        @endif {{-- / Form version --}}
    </div>

</div> {{-- /Element container --}}

{{-- Javascript: Depend On... --}}
@includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on')