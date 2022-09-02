@if($modelBinding)
    <form 
        {{ $attributes }} 
        action="{{ $action }}" 
        dusk="form-create-{{ $formId }}"
        class="w-full"
    >
        @csrf

        {{ $slot }}
    </form>
@else
    {{ $slot }}
@endif

{{-- Default tailwind values for width --}}
<span class="w-1/5 w-1/4 w-1/3 w-1/2 w-full"></span>