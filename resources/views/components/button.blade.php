@props([
    'uniqueKey' => $uniqueKey,
    'css' => $css,
    'text' => $text,
    'background' => config('action-forms.theme.colors')[$color],
    'type' => $type,
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    {{-- Show buttons --}}
    <button 
        id="button-{{ $uniqueKey }}"
        type="{{ $type }}"
        class="{{ $css->get('base') }} bg-{{ $background }}-500 hover:bg-{{ $background }}-600 border-{{ $background }}-400 text-white"
    >
        {{ $text }}
    </button>
@endif