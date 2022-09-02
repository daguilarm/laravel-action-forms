@if($modelBinding)
    <form {{ $attributes }} action="{{ $action }}" dusk="form-create-{{ $formId }}">
        @csrf
        {{ $slot }}
    </form>
@else
    {{ $slot }}
@endif