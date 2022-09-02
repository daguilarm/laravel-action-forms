@props([
    'inline' => false,
    'label' => $label,
    'width' => $width ?? 'w-full',
    'element' => $attributes->get('name'),
])

<div class="block {{ $width }}">
    @if($label)
        <label for="email" class="w-auto text-base text-gray-600 block font-medium">{{ $label }}</label>
    @endif
    <div class="mt-1.5">
        <input 
            class="w-full p-1.5 rounded-md border shadow text-base text-gray-500 @error($element) border-red-500 @else border-gray-200 @enderror" 
            {{ $attributes }} 
        />
        
        @error($element)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>