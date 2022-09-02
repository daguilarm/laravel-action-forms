@if($model)
    <form {{ $attributes }} action="{{ $action }}" dusk="form-create-{{ $id ?? $section ?? 'crud' }}">
        @csrf
        {{ $slot }}
    </form>
@else
    {{ $slot }}
@endif