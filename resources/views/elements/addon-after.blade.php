{{-- Addon after --}}
<span class="inline-flex items-center px-3 rounded-r-md border border-l-0 {{ $css->get('addons') }} @error($element) {{ $css->get('errorHighlight') }} @else {{ $css->get('addonsHighlight') }} @enderror">
    {{ $after }}
</span>