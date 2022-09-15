<div 
    x-data="{
        restoreElementData() {
            {{-- Get all the form element --}}
            let form = document.querySelector('[data-element=laravel-action-forms-container]');
            {{-- Get each element --}}
            [...form.elements].forEach((element) => {
                {{-- Get the database value --}}
                let database = element.dataset.value;
                {{-- If the database value is not empty --}}
                if(!this.isAnEmptyField(database)) {
                    element.value = database;
                    element.checked = database ? true : false;
                    element.disabled = false;
                    // remove disabled
                    document
                        .getElementById(element.dataset.key)
                        .classList
                        .remove('{{ config('action-forms.theme.disabled') }}')
                }
            });
        },
        // See if a value is empty
        isAnEmptyField(value) {
            return value == null || value == undefined || value == false || value ==  '' || value == 0 || value == NaN;
        },
        // See if the element is checkable
        isCheckable(element) {
            return element.getAttribute('type') === 'checkbox' || element.getAttribute('type') === 'radio';
        },
        // See if the element is checkable
        isCheckbox(element) {
            return element.getAttribute('type') === 'checkbox';
        },
        // Check if the element is a radio button
        isRadioButton(element) {
            return element.getAttribute('type') === 'radio';
        },
    }" 
>
    @if($config->get('section') === 'show')
        {{ $slot }}
    @else
        <form 
            {{ $attributes }} 
            action="{{ $action }}" 
            method="POST"
            dusk="form-create-{{ $attributes->get('id') ?? 'component' }}"
            class="{{ $css->get('base') }}"
            @isset($data) :data="$data" @endisset
            autocomplete="off"
            data-element="laravel-action-forms-container"
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
            {{-- Show restore button --}}
            @includeWhen(config('action-forms.restore_disabled') && $viewAction === 'edit', 'action-forms::elements.restore')
            {{-- Show components --}}
            {{ $slot }}
        </form>
    @endif
</div>

{{-- Javascript: form elements --}}
@includeWhen($viewAction !== 'show', 'action-forms::javascript.elements-js')
