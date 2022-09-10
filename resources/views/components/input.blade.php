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
    'addons' => $addons,
    'after' => $after,
    'before' => $before,
    'value' => af__value($attributes, 'name', $data),
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    <div 
        x-data="{
            parent: '{{ $dependOn }}',
            conditional: @json($conditional),
            value: `{{ $value }}`,
            valueEqueal: '{{ $dependOnValue }}',
            type: '{{ $dependOnType }}',
            disabled: false,
            visible: true,
            init() {
                this.disabled = af__disableOrEnable(this.parent, this.value, this.valueEqual, this.conditional, false, null);
                this.visible = this.type === 'hidden' ? !this.disabled : true;
            },
        }"
        id="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
        :class="disabled ? '{{ config('action-forms.theme.disabled') }}' : ''"
        x-show="visible"
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
                    x-on:change="this.disabled = window.af__enableOrDisableChildren($el)"
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
@endif {{-- /Form element container --}}