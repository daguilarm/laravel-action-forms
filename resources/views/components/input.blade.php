@props([
    'inline' => false,
    'label' => $label,
    'width' => $width,
])

<div class="{{ $inline ? 'flex justify-start items-center' : 'block' }} w-{{ $width }}">
    @if($label)
        <label for="email" class="w-auto {{ $inline ? 'pr-4 ' : '' }} block font-medium text-base text-gray-600">{{ $label }}</label>
    @endif
    <div class="mt-1.5 {{ $inline ? 'w-full' : '' }}">
        <input 
            class="w-full p-1.5 rounded-md border border-gray-200 shadow text-xl text-gray-500" 
            {{ $attributes }} 
        />
    </div>
</div>