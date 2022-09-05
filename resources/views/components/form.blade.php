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
            dusk="form-create-{{ $attributes->get('id') ?? 'component' }}"
            class="w-full"
            @isset($data) :data="$data" @endisset
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
            <div class="shadow rounded-md bg-gray-50 border border-100 px-8 py-6">
                {{ $slot }}
            </div>
        </form>
    @endif
</div>

{{-- Javascript: dependOn --}}
@includeWhen($viewAction !== 'show', 'action-forms::javascript.depend-on._function')


{{-- Safe list (for tailwindcss) --}}
@if(config('action-forms.tailwind-safe-list'))
    <span id="theme-safe-css" class="hidden {{ $safeCssClasses }}">Tailwind Safe List</span>
@endif
