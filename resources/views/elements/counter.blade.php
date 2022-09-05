{{-- Chars counter --}}
<div class="{{ config('action-forms.theme.textarea.counter') }}">
    <span x-html="count"></span> / <span x-html="$refs.{{ $element }}.maxLength"></span>
</div>