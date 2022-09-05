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
        data-container="{{ $uniqueKey }}"
        class="block {{ $width }} mb-6"
        
        {{-- DependOn Condition: hidden --}}
        @includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on.hidden')
    >
        {{-- Add label --}}
        @includeWhen($label, 'action-forms::elements.label')
        
        {{-- Element container --}}
        <div x-data="{}">
            <div class="flex mt-1.5">

                {{-- Addon before --}}
                @includeWhen($before, 'action-forms::elements.addon-before')

                {{-- Input field --}}
                <input 
                    data-element="{{ $uniqueKey }}"
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="{{ $css->get('base') }} {{ $addons }} @include('action-forms::elements.validation-highlight')" 
                    value="{{ $value }}"

                    {{-- Native attributes --}}
                    {{ $attributes }} 

                    {{-- DependOn Conditions: Disabled --}}
                    @includeWhen($dependOnValue && $dependOnType, 'action-forms::javascript.depend-on.disabled')
                />

                {{-- Addon after --}}
                @includeWhen($after, 'action-forms::elements.addon-after')
            </div>

            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>

    </div> {{-- /Element container --}}

    {{-- Javascript: Depend On... --}}
    @includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on')

@endif {{-- /Form element container --}}