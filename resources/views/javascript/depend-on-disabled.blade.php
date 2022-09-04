{{-- DependOn Condition: Disabled --}}
@if($dependOnType === 'disabled')
    x-bind:disabled="@json($dependOnValue)"
@endif