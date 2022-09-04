{{-- Addon before --}}
@if($before)
    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 {{ config('action-forms.theme.input.addons.text') }} {{ config('action-forms.theme.input.addons.bg') }} {{ config('action-forms.theme.input.shadow') }} @error($element) {{ config('action-forms.theme.messages.errors.border') }} @else {{ config('action-forms.theme.input.addons.border') }} @enderror">
        {{ $before }}
    </span>
@endif 