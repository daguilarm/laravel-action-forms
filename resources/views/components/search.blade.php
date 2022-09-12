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
    'default' => $default,
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    <div 
        x-data="
            formData(
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
        <div x-data="{
            searchElement: '',
            searchResults: [],
            isLoading: false,
            searchEngine() {
                if(this.searchElement.length >= 1) {
                    this.isLoading = true;
                    fetch('https://agronoom.test/dashboard/api/user?query=' + this.searchElement)
                        .then(response => response.json())
                        .then(data => {
                        this.isLoading = false;
                        this.searchResults = data;
                    });
                }
            },
        }">
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
                    name="hiden__{{ $element }}"
                />
                <input type="hidden" name="{{ $element }}" />
                {{-- Search icon --}}
                <div id="datalist-{{ $element }}" class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <!-- Heroicon name: search -->
                    <svg x-show="!isLoading" class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" strokeWidth={1.5} stroke="currentColor" fill="none" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <!-- Heroicon name: loading -->
                    <svg x-show="isLoading" class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
            </div>
            {{-- Result --}}
            <div 
                class="bg-transparent mt-1" 
                x-show="searchResults.length > 0" 
            >
                <template x-for="result in searchResults">
                    <div class="block py-2 px-3 cursor-pointer border-b border-gray-100 last:border-0 text-cyan-700 text-sm bg-gray-50 hover:bg-cyan-600 hover:text-white" x-text="result.name"></div>
                </template>
            </div>
            {{-- Validation errors and Helper --}}
            @include('action-forms::elements.helper-and-validation')
        </div>
    </div> {{-- /Element container --}}
@else 
    @include('action-forms::elements.show')
@endif {{-- /Form element container --}}