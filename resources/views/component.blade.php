{{-- Push Javascript: Depend On... --}}
@includeWhen($dependOn && $dependOnType && $viewAction !== 'show', 'action-forms::javascript.depend-on.onchange')

{{-- Show container --}}
@includeWhen($viewAction === 'show', 'action-forms::elements.show')