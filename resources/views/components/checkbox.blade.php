@props([
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType ?? 'disabled',
    'dependOnValue' => $dependOn ? true : false,
    'label' => $label,
    'element' => $attributes->get('name'),
    'helper' => $helper ?? null,
    'uniqueKey' => $uniqueKey,
    'css' => $css,
])

@php
    $value = old($element, $data->{$element} ?? null);
    $checked = $value ? true : false;
@endphp

{{-- Show container --}}
@if($viewAction === 'show')
    @include('action-forms::elements.show')

{{-- Form element container --}}
@else 

    {{-- Element container --}}
    <div 
        data-container="{{ $uniqueKey }}"
        class="block {{ $width }} mb-6"

        {{-- DependOn Condition: hidden --}}
        @includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on.hidden')
    >
        {{-- Element --}}
        <div x-data="">
            <div class="flex items-center mt-1.5 mb-4">
            
                <input 
                    type="checkbox" 
                    data-element="{{ $uniqueKey }}"
                    class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')"
                    value="{{ $value }}"
                    {{ $checked ? 'checked' : '' }}
                    {{ $attributes }}

                    {{-- DependOn Conditions: Disabled --}}
                    @includeWhen($dependOnValue && $dependOnType, 'action-forms::javascript.depend-on.disabled')
                >

                {{-- Label --}}
                @includeWhen($label, 'action-forms::elements.label')
            </div>

            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}

    {{-- Javascript: Depend On... --}}
    @includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on')

@endif {{-- /Form element container --}}
