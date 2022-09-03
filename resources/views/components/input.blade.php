@props([
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType ?? 'disable',
    'dependOnValue' => $dependOn ? true : false,
    'inline' => false,
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
        <label for="email" class="w-auto text-base {{ config('action-forms.label-color') }} block font-medium">{{ $label }}</label>
    @endif

    {{-- Element --}}
    <div class="mt-1.5">
        <input 
            data-element="{{ $uniqueKey }}"
            class="w-full p-1.5 rounded-md border text-base focus:outline-none {{ config('action-forms.shadow') ? 'shadow' : '' }} {{ config('action-forms.element-color') }} {{ config('action-forms.element-placeholder') }} {{ implode(' ', config('action-forms.element-focus')) }} @error($element) border-red-500 @else border-gray-200 @enderror" 

            {{-- DependOn Conditions: Disabled --}}
            @if($dependOnType === 'disabled')
                x-bind:disabled="@json($dependOnValue)"
            @endif
            
            {{ $attributes }} 
        />
        
        {{-- Validation errors --}}
        @error($element)
            <div class="p-1 mt-1 text-sm {{ config('action-forms.error-color') }} font-semibold">{{ $message }}</div>
        @enderror

        {{-- Helper text --}}
        @if($helper)
            <div class="p-1 mt-1 text-sm {{ config('action-forms.helper-color') }} italic font-normal">{{ $helper }}</div>
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