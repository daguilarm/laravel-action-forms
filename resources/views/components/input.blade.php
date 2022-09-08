@props([
    'conditional' => $conditional,
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
    $booleanValue = $value ? true : false;
@endphp

{{-- Show container --}}
@if($viewAction === 'show')
    @include('action-forms::elements.show')

{{-- Form element container --}}
@else 
    <div 
        x-data="{
            conditional: '{{ $conditional }}',
            parent: '{{ $dependOn }}',
            init() {
                if(this.parent) {
                    window.__af_dependOn(
                        this.parent, 
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
        {{-- Add label --}}
        @includeWhen($label, 'action-forms::elements.label')
        
        {{-- Element container --}}
        <div>
            <div class="flex mt-1.5">

                {{-- Addon before --}}
                @includeWhen($before, 'action-forms::elements.addon-before')

                {{-- Input field --}}
                <input 
                    data-element="{{ $uniqueKey }}"
                    data-parent="parent__{{ $element }}"
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

{{-- Push Javascript: Depend On... --}}
@includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on.onchange')