@props([
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType ?? 'disable',
    'dependOnValue' => $dependOn ? true : false,
    'after' => $after ? true : false,
    'before' => $before ? true : false,
    'addons' => $addons,
    'label' => $label,
    'width' => $width ?? 'w-full',
    'element' => $attributes->get('name'),
    'helper' => $helper ?? null,
    'uniqueKey' => str()->uuid(),
])

{{-- Element container --}}
<div 
    data-container="{{ $uniqueKey }}"
    class="block {{ $width }} mb-6"

    {{-- DependOn Conditions: hidden --}}
    @if($dependOnType === 'hidden')
        :class="@json($dependOnValue) ? 'hidden' : 'block'"
    @endif
>
    {{-- Add label --}}
    @if($label)
        <label 
            for="{{ $element }}" 
            class="w-auto block {{ config('action-forms.theme.label.text') }}"
        >
            {{ $label }}
        </label>
    @endif

    {{-- Element --}}
    <div class="mt-1.5">

        {{-- Text version --}}
        @if($viewAction === 'show')
            <div class="flex">
                {{-- Addon before --}}
                @include('action-forms::elements.addon-before')

                <div class="w-full p-2 border focus:outline-none {{ $addons }} {{ config('action-forms.theme.input.text') }} {{ config('action-forms.theme.input.bg') }} {{ config('action-forms.theme::input.shadow') }}">
                    {{ $data->{$attributes->get('name')} }}
                </div>

                {{-- Addon after --}}
                @include('action-forms::elements.addon-after')
            </div>
            
        {{-- Form version --}}
        @else 
            <div class="flex">
                
                {{-- Addon before --}}
                @include('action-forms::elements.addon-before')

                <input 
                    data-element="{{ $uniqueKey }}"
                    dusk="form-create-{{ $attributes->get('id') ?? $element }}"
                    class="w-full flex-1 py-1.5 px-2 border focus:outline-none {{ $addons }} {{ config('action-forms.theme.input.text') }} {{ config('action-forms.theme.input.bg') }} {{ config('action-forms.theme.input.shadow') }} {{ config('action-forms.theme.input.placeholder') }} {{ config('action-forms.theme.input.focus') }} @error($element) {{ config('action-forms.theme.messages.errors.border') }} @else {{ config('action-forms.theme.input.border') }} @enderror" 
    
                    {{-- DependOn Conditions: Disabled --}}
                    @if($dependOnType === 'disabled')
                        x-bind:disabled="@json($dependOnValue)"
                    @endif

                    value="{{ old($element, $data->{$element} ?? null) }}"
                    
                    {{ $attributes }} 
                />


                {{-- Addon after --}}
                @include('action-forms::elements.addon-after')
            </div>

            {{-- Validation errors --}}
            @error($element)
                <div class="p-1 mt-1 {{ config('action-forms.theme.messages.errors.text') }}">{{ $message }}</div>
            @enderror

            {{-- Helper text --}}
            @if($helper)
                <div class="p-1 mt-1 {{ config('action-forms.theme.input.helper') }}">{{ $helper }}</div>
            @endif

        @endif

    </div>
</div>

{{-- Javascript events --}}
@if($dependOn)
    <script>
        document
            .querySelector('[name={{ $dependOn }}]')
            .addEventListener('change', (element) => {  
                // Get the container and the current element  
                let currentContainer = document.querySelector('[data-container="{{ $uniqueKey }}"]');  
                let currentElement = document.querySelector('[data-element="{{ $uniqueKey }}"]');   

                // The element is active
                if(element.target.value) {

                    @if($dependOnType === 'disabled') currentElement.disabled = false; @endif
                    @if($dependOnType === 'hidden') currentContainer.classList.remove('hidden'); @endif
                
                // The element is disabled
                } else {

                    @if($dependOnType === 'disabled') currentElement.disabled = true; @endif
                    @if($dependOnType === 'hidden') currentContainer.classList.add('hidden'); @endif

                    // Reset value
                    currentElement.value = '';

                    // Create an onchange evet
                    currentElement.dispatchEvent(new Event('change'));
                }
        })
    </script>
@endif