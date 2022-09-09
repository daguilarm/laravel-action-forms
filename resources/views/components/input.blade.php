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
    'value' => old(
        $attributes->get('name'), 
        $data->{$attributes->get('name')} ?? null
    ),
])

{{-- Javascript: Depend On... --}}
@push('action-forms-scripts')
    <script $_key="{{ str()->uuid() }}">
        // Disable or enable element
        window.af__disableOrEnable = function(parent, value, valueEqual, conditional, hasChildren, currentElement) {
            let disabled = true;
            // If field has not parent, then visible
            if(!parent) {
                disabled = false;
            // If field has parent, then start the magic!
            } else {
                // Show or hide base on condition
                if(conditional) {
                    visible = conditional ? true : false;
                    disabled = ! visible;
                // Edit action
                } else if(value) {
                    return false;
                // With no condition
                } else {
                    // Get all the parents
                    let fieldParent = document.querySelectorAll('[data-parent=' + parent.name + ']');
                    // One by one
                    [].map.call(fieldParent, element => {
                        // If parent is a checkbox or a radio button
                        if(element.getAttribute('type') === 'checkbox' || element.getAttribute('type') === 'radio') {
                            // If parent is checked, then enable child
                            if(element.checked) {
                                disabled = false;
                            }
                        // Input, select and textareas fields
                        } else {
                            // If parent has a value and valueEqual is not defined, then enable child
                            if(element.value && !valueEqual) {
                                disabled = false;
                            }
                            // If parent has a value and is equal to valueEqual, then enable child
                            if(element.value && valueEqual && element.value === valueEqual) {
                                disabled = false;
                            } 
                        }
                    });
                }
            }
            // Check for children
            if(hasChildren) {
                window.af__enableOrDisableChildren(currentElement);
            }
            // Send all the magic
            return disabled;
        }
        // Disable or enable children
        window.af__enableOrDisableChildren = function(parent) {
            let children = document.querySelectorAll('[data-parent=' + parent.name + ']');
            // disable or enable all the children
            [].map.call(children, element => {
                let container = document.getElementById(element.dataset.key);
                window.af__reset_element(container, element);
            });
        },
        // Reset element
        window.af__reset_element = function(container, element) {
            // Reset container
            container.visible = true;
            container.classList.remove('{{ config('action-forms.theme.disabled') }}')
            // Reset element and set default values
            element.disabled = false;
            element.checked = element.value ? true : false;
        }
    </script>
@endpush

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    <div 
        x-data="{
            parent: '{{ $dependOn }}',
            conditional: @json($conditional),
            value: '{{ $value }}',
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