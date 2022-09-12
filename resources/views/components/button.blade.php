@props([
    'uniqueKey' => $uniqueKey,
    'css' => $css,
    'conditional' => $conditional,
    'text' => $text,
    'background' => config('action-forms.theme.colors')[$color],
    'type' => $type,
])

{{-- Form-element container --}}
@if($viewAction !== 'show') 
    {{-- Show buttons --}}
    <div 
        x-data="{
            conditional: Boolean(@json($conditional)),
        }"
    >
        <button 
            id="button-{{ $uniqueKey }}"
            type="{{ $type }}"
            x-show="conditional"
            @foreach($javascript as $key => $value)
                {{ af__render_js($key, $value) }}
            @endforeach
            class="{{ $css->get('base') }} bg-{{ $background }}-{{ config('action-forms.theme.color_darkness.base') }} hover:bg-{{ $background }}-{{ config('action-forms.theme.color_darkness.hover') }} border-{{ $background }}-{{ config('action-forms.theme.color_darkness.border') }} text-white"
        >
            {{ $text }}
        </button>
    </div>
@endif