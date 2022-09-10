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
    'value' => af__value($attributes, 'name', $data),
    'databaseValue' => $data->{$attributes->get('name')} ?? null,
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    {{-- Element container --}}
    <div 
        x-data="{
            parent: '{{ $dependOn }}',
            conditional: @json($conditional),
            value: '{{ $value }}',
            valueEqueal: '{{ $dependOnValue }}',
            databaseValue: '{{ $databaseValue }}',
            type: '{{ $dependOnType }}',
            disabled: false,
            visible: true,
            checked: this.databaseValue ? true : false,
            init() {
                this.disabled = af__disableOrEnable(this.parent, this.value, this.valueEqual, this.conditional, false, $refs.__{{ $uniqueKey }});
                this.visible = this.type === 'hidden' ? !this.disabled : true;
            },
        }"
        id="{{ $uniqueKey }}"
        class="{{ $width }} {{ $cssElement }}"
        :class="disabled ? '{{ config('action-forms.theme.disabled') }}' : ''"
        x-show="visible"
    >
        {{-- Element --}}
        <div>
            <div class="flex items-center mt-1.5 mb-4">
                {{-- Checkbox field --}}
                <input 
                    type="checkbox"
                    x-ref="__{{ $uniqueKey }}"
                    x-on:change="this.disabled = window.af__enableOrDisableChildren($el)"
                    :disabled="disabled"
                    :checked="checked"
                    :value="value"
                    data-key="{{ $uniqueKey }}"
                    data-value="{{ $value }}"
                    data-parent="{{ $dependOn }}"
                    data-field="__{{ $uniqueKey }}"
                    data-equal="{{ $dependOnValue }}"
                    data-condition="{{ $conditional }}"
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight')" 
                    {{-- Native attributes --}}
                    {{ $attributes }} 
                >
                {{-- Label --}}
                @includeWhen($label, 'action-forms::elements.label')
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@endif {{-- /Form-element container --}}