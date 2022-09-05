{{-- Validation errors --}}
@error($element)
    <div class="{{ config('action-forms.theme.messages.errors.base') }}">{{ $message }}</div>
@enderror