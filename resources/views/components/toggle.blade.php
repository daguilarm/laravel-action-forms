@props([
    'element' => $attributes->get('name'),
    'value' => af__value($attributes, 'name', $data),
    'background' => config('action-forms.theme.colors')[$color],
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    <div 
        x-data="formData(
            '{{ $dependOn }}', 
            @json($conditional ?? true), 
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
        
        {{-- Element container --}}
        <div                                 
            x-on:click="checked = ! checked"
        >
            <div class="flex mt-1.5">
                <div class="flex items-center justify-start w-full mb-12">
                    <label for="{{ $element }}" class="flex items-center cursor-pointer">
                        <!-- toggle -->
                        <div class="relative">
                            {{-- Input field --}}
                            <input 
                                type="checkbox"
                                x-ref="__{{ $uniqueKey }}"
                                x-on:change="enableOrDisableChildren($el)"
                                :value="value"
                                :disabled="disabled"
                                :checked="checked"
                                data-key="{{ $uniqueKey }}"
                                data-value="{{ $value }}"
                                data-parent="{{ $dependOn }}"
                                data-field="__{{ $uniqueKey }}"
                                data-equal="{{ $dependOnValue }}"
                                data-condition="{{ $conditional }}"
                                dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                                class="sr-only"
                                {{-- Native attributes --}}
                                {{ $attributes }} 
                            />
                            <!-- line -->
                            <div 
                                class="block w-14 h-8 rounded-full"
                                :class="checked ? 'bg-{{ $background }}-500' : 'bg-gray-300'"
                            ></div>
                            <!-- dot -->
                            <div :class="checked ? 'translate-x-full' : ''" class="dot absolute bg-white left-1 top-1 w-6 h-6 rounded-full transition"></div>
                        </div>
                    </label>
                </div>
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
{{-- view action: show --}}
@else 
    @include('action-forms::elements.show')
@endif {{-- /Form element container --}}