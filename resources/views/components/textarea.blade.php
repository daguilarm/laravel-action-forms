@props([
    'element' => $attributes->get('name'),
    'uniqueKey' => $uniqueKey,
    'css' => $css,
    'conditional' => $conditional,
    'width' => $width,
    'label' => $label,
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType,
    'dependOnValue' => $dependOnValue,
    'helper' => $helper,
    'maxlength' => $maxlength,
    'rows' => $rows,
    'counter' => $counter,
    'value' => af__value($attributes, 'name', $data),
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    {{-- Element container --}}
    <div 
        x-data="formData(
            '{{ $dependOn }}', 
            @json($conditional), 
            `{{ $value }}`, 
            '{{ $dependOnValue }}', 
            '{{ $dependOnType }}', 
            databaseValue = null, 
            $refs.__{{ $uniqueKey }}
        )"
        id="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
        x-show="visible"
        :class="disabled ? disabledClass : ''"
    >
        {{-- Add label --}}
        @includeWhen($label, 'action-forms::elements.label')
        <div>
            {{-- Texarea field --}}
            <textarea 
                x-ref="__{{ $uniqueKey }}"
                x-on:keyup="count = $el.value.length"
                x-on:updatecounter="count = $event.detail.value"
                x-on:focus="$dispatch('updatecounter', {value: $el.value.length}); counterVisible = true;"
                x-on:click.outside="counterVisible = false"
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
                class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')"
                maxlength="{{ $maxlength }}"
                rows="{{ $rows }}" 
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
                <span x-html="count"></span> / <span x-html="$refs.__{{ $uniqueKey }}.maxLength"></span>
            </div>
        @endif
    </div> {{-- /Element container --}}
@endif 
