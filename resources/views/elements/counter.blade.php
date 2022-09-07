{{-- Chars counter --}}
<div class="{{ $css->get('counter') }}">
    <span x-html="count"></span> / <span x-html="$refs.t__{{ $element }}.maxLength"></span>
</div>