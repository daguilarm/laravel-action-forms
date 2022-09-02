@props([
    'inline' => false,
    'label' => $label,
    'width' => $width ?? 'w-full',
    'element' => $attributes->get('name'),
    'helper' => $helper ?? null,
])

<div class="block {{ $width }}">
    @if($label)
        <label for="email" class="w-auto text-base {{ config('action-forms.label-color') }} block font-medium">{{ $label }}</label>
    @endif
    <div class="mt-1.5">
        <input 
            class="w-full p-1.5 rounded-md border text-base focus:outline-none {{ config('action-forms.shadow') ? 'shadow' : '' }} {{ config('action-forms.element-color') }} {{ config('action-forms.element-placeholder') }} {{ implode(' ', config('action-forms.element-focus')) }} @error($element) border-red-500 @else border-gray-200 @enderror" 
            {{ $attributes }} 
        />

        @error($element)
            <div class="p-1 mt-1 text-sm {{ config('action-forms.error-color') }} font-semibold">{{ $message }}</div>
        @enderror

        @if($helper)
            <div class="p-1 mt-1 text-sm {{ config('action-forms.helper-color') }} italic font-normal">{{ $helper }}</div>
        @endif
    </div>
</div>