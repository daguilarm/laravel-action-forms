@props([
    'element' => $attributes->get('name'),
    'value' => af__value($attributes, 'name', $data),
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    <div 
        x-data="
            formElement(
                '{{ $dependOn }}', 
                @json($conditional ?? true), 
                `{{ $value }}`, 
                '{{ $dependOnValue }}', 
                '{{ $dependOnType }}', 
                databaseValue = null, 
                $refs.__{{ $uniqueKey }}
            )
        "
        id="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
        x-show="visible"
        :class="disabled ? disabledClass : ''"
    >
        {{-- Add label --}}
        @includeWhen($label, 'action-forms::elements.label')
        
        {{-- Element container --}}
        <div>
            <div class="flex mt-1.5">
                {{-- Addon before --}}
                @if($before)
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 {{ $css->get('addons') }} @error($element) {{ $css->get('errorHighlight') }} @else {{ $css->get('addonsHighlight') }} @enderror">
                        {{ $before }}
                    </span>
                @endif
                {{-- Input field --}}
                <input 
                    x-ref="__{{ $uniqueKey }}"
                    x-on:change="enableOrDisableChildren($el)"
                    :value="value"
                    :disabled="disabled"
                    data-key="{{ $uniqueKey }}"
                    data-value="{{ $value }}"
                    data-parent="{{ $dependOn }}"
                    data-field="__{{ $uniqueKey }}"
                    data-equal="{{ $dependOnValue }}"
                    data-condition="{{ $conditional }}"
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="{{ $css->get('base') }} {{ $addons }} @include('action-forms::elements.validation-highlight')" 
                    {{-- Native attributes --}}
                    {{ $attributes }} 
                />
                {{-- Addon after --}}
                @if($after)
                    <span class="af_element_disabled_{{ $uniqueKey }} inline-flex items-center px-3 rounded-r-md border border-l-0 {{ $css->get('addons') }} @error($element) {{ $css->get('errorHighlight') }} @else {{ $css->get('addonsHighlight') }} @enderror">
                        {{ $after }}
                    </span>
                @endif
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
{{-- view action: show --}}
@else 
    @include('action-forms::elements.show')
@endif {{-- /Form element container --}}