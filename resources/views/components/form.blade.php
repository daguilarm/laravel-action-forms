@php
    $id = $attributes->get('id');
@endphp

<div 
    x-data="{formData: []}" 
    id="laravel-action-form-component"
>
    @if($modelBinding)
        <form 
            {{ $attributes }} 
            action="{{ $action }}" 
            dusk="form-create-{{ $id }}"
            class="w-full"
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
    @else
        {{ $slot }}
    @endif
</div>
