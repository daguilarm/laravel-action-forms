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

            {{ $slot }}
        </form>
    @endif
</div>
