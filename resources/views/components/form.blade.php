<div 
    x-data="{formData: []}" 
    id="laravel-action-form-component"
>
    @if($config->get('section') === 'show')
        {{ $slot }}
    @else
        <form 
            {{ $attributes }} 
            action="{{ $action }}" 
            method="POST"
            dusk="form-create-{{ $attributes->get('id') ?? 'component' }}"
            class="{{ $css->get('base') }}"
            @isset($data) :data="$data" @endisset
            autocomplete="off"
        >
            @csrf
            @method(match($method) {
                'get' => 'GET',
                'delete' => 'DELETE',
                'destroy' => 'DELETE',
                'update' => 'PATCH',
                'edit' => 'PATCH',
                default => 'POST',
            })
            {{ $slot }}

            <button type="submit">Enviar</button>
        </form>
    @endif
</div>

{{-- Javascript: dependOn --}}
@includeWhen($viewAction !== 'show', 'action-forms::javascript.depend-on.functions')


{{-- Safe list (for tailwindcss) --}}
@if(config('action-forms.tailwind-safe-list'))
    <span id="theme-safe-css" class="hidden {{ $safeCssClasses }}">Tailwind Safe List</span>
@endif
