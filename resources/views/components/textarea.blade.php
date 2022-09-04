@props([
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType ?? 'disabled',
    'dependOnValue' => $dependOn ? true : false,
    'label' => $label,
    'width' => $width ?? 'w-full',
    'maxlength' => $maxlength,
    'rows' => $rows,
    'count' => $count,
    'element' => $attributes->get('name'),
    'helper' => $helper ?? null,
    'uniqueKey' => $uniqueKey,
])

{{-- Element container --}}
<div 
    data-container="{{ $uniqueKey }}"
    class="block {{ $width }} mb-6"

    {{-- DependOn Condition: hidden --}}
    @includeWhen($dependOnValue && $dependOnType, 'action-forms::javascript.depend-on-hidden')
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

                <div 
                    dusk="form-textarea-{{ $attributes->get('id') ?? $element }}"
                    class="w-full p-2 border focus:outline-none {{ config('action-forms.theme.input.text') }} {{ config('action-forms.theme.input.bg') }} {{ config('action-forms.theme::input.shadow') }}"
                >                    
                    {{ $data->{$element} }}
                </div>

            </div>
            
        {{-- Form version --}}
        @else
            <div                 
                x-data="{ count: 0 }" 
                x-init="count = $refs.{{ $element }}.value.length"
            >
                <div class="flex">

                    <textarea 
                        x-ref="{{ $element }}" 
                        x-on:keyup="count = $refs.{{ $element }}.value.length"
                        data-element="{{ $uniqueKey }}"
                        dusk="form-textarea-{{ $attributes->get('id') ?? $element }}"
                        maxlength="{{ $maxlength }}"
                        rows="{{ $rows }}"
                        class="w-full flex-1 py-1.5 px-2 rounded-md border focus:outline-none {{ config('action-forms.theme.input.text') }} {{ config('action-forms.theme.input.bg') }} {{ config('action-forms.theme.input.shadow') }} {{ config('action-forms.theme.input.placeholder') }} {{ config('action-forms.theme.input.focus') }} {{ config('action-forms.theme.input.focus') }} @error($element) {{ config('action-forms.theme.messages.errors.border') }} @else {{ config('action-forms.theme.input.border') }} @enderror" 
        
                        {{-- DependOn Conditions: Disabled --}}
                        @includeWhen($dependOnValue && $dependOnType, 'action-forms::javascript.depend-on-disabled')
                        
                        {{ $attributes }} 
                    >{{ trim(old($element, $data->{$element} ?? null)) }}</textarea>

                </div>

                {{-- Validation errors --}}
                @error($element)
                    <div class="p-1 mt-1 {{ config('action-forms.theme.messages.errors.text') }}">{{ $message }}</div>
                @enderror

                {{-- Helper text --}}
                @if($helper)
                    <div class="p-1 mt-1 {{ config('action-forms.theme.input.helper') }}">{{ $helper }}</div>
                @endif

                {{-- Chars counter --}}
                @if($count)
                    <div class="{{ config('action-forms.theme.textarea.counter') }}">
                        <span x-html="count"></span> / <span x-html="$refs.{{ $element }}.maxLength"></span>
                    </div>
                @endif
            </div>
            
        @endif

    </div>
</div>

{{-- Javascript: Depend On... --}}
@include('action-forms::javascript.depend-on')