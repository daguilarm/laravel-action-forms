<?php

namespace Daguilarm\ActionForms\Components;

use Illuminate\View\View;

class Radio extends Checkbox
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.radio');
    }
}
