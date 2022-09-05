@props([
    'dependOn' => $dependOn,
    'dependOnType' => $dependOnType ?? 'disabled',
    'dependOnValue' => $dependOn ? true : false,
    'after' => $after,
    'before' => $before,
    'addons' => $addons,
    'label' => $label,
    'width' => $width ?? 'w-full',
    'element' => $attributes->get('name'),
    'helper' => $helper ?? null,
    'uniqueKey' => $uniqueKey,
])

{{-- Element container --}}
<div 
    data-container="{{ $uniqueKey }}"
    class="block {{ $width }} mb-6"
    {{-- DependOn Condition: hidden --}}
    @includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on.hidden')
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
                <div 
                    dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                    class="w-full p-2 border focus:outline-none {{ $addons }} {{ config('action-forms.theme.input.text') }} {{ config('action-forms.theme.input.bg') }} {{ config('action-forms.theme::input.shadow') }}"
                >
                    {{ $data->{$element} }}
                </div>
                {{-- Addon after --}}
                @include('action-forms::elements.addon-after')
            </div> 
        {{-- Form version --}}
        @else 
            <div x-data="">
                <div class="flex">
                    {{-- Addon before --}}
                    @include('action-forms::elements.addon-before')
                    <input 
                        data-element="{{ $uniqueKey }}"
                        dusk="form-input-{{ $attributes->get('id') ?? $element }}"
                        class="w-full flex-1 py-1.5 px-2 border focus:outline-none {{ $addons }} {{ config('action-forms.theme.input.text') }} {{ config('action-forms.theme.input.bg') }} {{ config('action-forms.theme.input.shadow') }} {{ config('action-forms.theme.input.placeholder') }} {{ config('action-forms.theme.input.focus') }} {{ config('action-forms.theme.input.disabled') }} @error($element) {{ config('action-forms.theme.messages.errors.border') }} @else {{ config('action-forms.theme.input.border') }} @enderror" 
                        value="{{ old($element, $data->{$element} ?? null) }}"
                        {{ $attributes }} 
                        {{-- DependOn Conditions: Disabled --}}
                        @includeWhen($dependOnValue && $dependOnType, 'action-forms::javascript.depend-on.disabled')
                    />
                    {{-- Addon after --}}
                    @include('action-forms::elements.addon-after')
                </div>
                {{-- Validation errors and Helper --}}
                @include('action-forms::elements.helper-and-validation')
            </div>
        @endif
    </div>
</div>
{{-- Javascript: Depend On... --}}
@includeWhen($dependOnValue && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on')