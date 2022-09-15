@props([
    'element' => $attributes->get('name'),
    'value' => af__value($attributes, 'name', $data),
    'minChars' => $minChars,
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
        class="{{ $width }} {{ $cssElement }} relative"
        x-show="visible"
        :class="disabled ? disabledClass : ''"
    >
        {{-- Add label --}}
        @includeWhen($label, 'action-forms::elements.label')
        
        {{-- Element container --}}
        <div x-data="            
            formSearch(
                '{{ $element }}', 
                '{{ $requestId }}', 
                '{{ $requestValue}}', 
                {{ json_encode($requestFromArray) }},
                '{{ $requestFrom }}',
                '{{ $minChars }}'
            )
        ">
            <div class="flex mt-1.5 relative">
                {{-- search field --}}
                <input 
                    type="text"
                    x-ref="__{{ $uniqueKey }}"
                    x-on:change="enableOrDisableChildren($el)"
                    x-model="searchElement"
                    x-on:keydown.debounce.500ms="searchEngine()"
                    :value="value"
                    :disabled="disabled"
                    data-key="{{ $uniqueKey }}"
                    data-value="{{ $value }}"
                    data-parent="{{ $dependOn }}"
                    data-field="__{{ $uniqueKey }}"
                    data-equal="{{ $dependOnValue }}"
                    data-condition="{{ $conditional }}"
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="{{ $css->get('base') }} @include('action-forms::elements.validation-highlight') pl-10" 
                    {{-- Native attributes --}}
                    {{ $attributes }}
                />
                <input type="hidden" data-element="hidden__{{ $element }}" name="__{{ $element }}" :disabled="disabled" value="">
                {{-- Search icon --}}
                <div id="search-icons-{{ $element }}" class="{{ $css->get('icon_container') }}">
                    <!-- Heroicon name: search -->
                    <svg 
                        x-show="!isLoading" 
                        class="{{ $css->get('icon') }}" 
                        xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 20 20" 
                        stroke-width="1.5" 
                        stroke="currentColor" 
                        fill="none" 
                    >
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" 
                        />
                    </svg>
                    <!-- Heroicon name: loading -->
                    <svg 
                        x-show="isLoading" 
                        class="animate-spin {{ $css->get('icon') }}" 
                        xmlns="http://www.w3.org/2000/svg" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke-width="1.5" 
                        stroke="currentColor"
                    >
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" 
                        />
                    </svg>
                </div>
            </div>
            {{-- Result --}}
            <div 
                class="{{ $css->get('result_container') }}" 
                style="z-index: 99 !important"
                x-show="showElement()" 
                @click.outside="resetElement()"
            >
                <template 
                    x-for="result in searchResults" 
                >
                    <div 
                        class="{{ $css->get('result') }}" 
                        style="z-index: 999 !important"
                        x-text="result.name"
                        x-on:click="selectElement(result)"
                    ></div>
                </template>
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@else 
    @include('action-forms::elements.show')
@endif {{-- /Form element container --}}

{{-- Javascript: form search --}}
@includeWhen($viewAction !== 'show', 'action-forms::javascript.search-js')