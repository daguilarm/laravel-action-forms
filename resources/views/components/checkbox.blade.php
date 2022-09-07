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
    $booleanValue = $value ? true : false;
    $checked = $value ? true : false;
@endphp

{{-- Show container --}}
@if($viewAction === 'show')
    @include('action-forms::elements.show')

{{-- Form element container --}}
@else 

    {{-- Element container --}}
    <div 
        x-data
        @if($dependOn)
            x-init="window.__af_dependOn('{{ $dependOn }}', '{{ $dependOnType }}', '{{ $booleanValue }}', '{{ $uniqueKey }}')"
        @endif
        data-container="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
    >
        {{-- Element --}}
        <div>
            <div class="flex items-center mt-1.5 mb-4">
            
                <input 
                    type="checkbox" 
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

@endif {{-- /Form element container --}}

{{-- Push Javascript: Depend On... --}}
@includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on.onchange')