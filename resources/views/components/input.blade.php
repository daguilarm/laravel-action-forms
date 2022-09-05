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
                
                {{-- Addon before --}}
                @includeWhen($before, 'action-forms::elements.addon-before')
                
                {{-- Show container --}}
                <div 
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="w-full p-2 border focus:outline-none {{ $addons }} {{ config('action-forms.theme.input.text') }} {{ config('action-forms.theme.input.bg') }} {{ config('action-forms.theme::input.shadow') }}"
                >
                    {{ $data->{$element} }}
                </div>

                {{-- Addon after --}}
                @includeWhen($after, 'action-forms::elements.addon-after')
            </div> 
        
            {{-- Form version --}}
        @else 
            <div x-data="">
                <div class="flex">

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
        
        @endif {{-- / Form version --}}
    </div>

</div> {{-- /Element container --}}

{{-- Javascript: Depend On... --}}
@includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on')