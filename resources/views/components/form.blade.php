@props([
    'method' => match($method) {
        'get' => 'GET',
        'delete' => 'DELETE',
        'destroy' => 'DELETE',
        'update' => 'PATCH',
        'edit' => 'PATCH',
        default => 'POST',
    }
])

<div x-data="{}">
    @if($modelBinding)
        <form 
            {{ $attributes }} 
            action="{{ $action }}" 
            dusk="form-create-{{ $formId }}"
            class="w-full"
        >
            @csrf
            @method($method)

            {{ $slot }}
        </form>
    @else
        {{ $slot }}
    @endif
</div>