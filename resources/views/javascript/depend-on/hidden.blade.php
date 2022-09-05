{{-- DependOn Condition: hidden --}}
@if($dependOnType === 'hidden')
    :class="@json($dependOnValue) ? 'hidden' : 'block'"
@endif