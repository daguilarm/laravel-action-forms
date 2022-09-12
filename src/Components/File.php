<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class File extends FormComponent
{
    use Configable;

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.file', [
            'css' => config('action-forms.theme.file'),
        ]);
    }
}
