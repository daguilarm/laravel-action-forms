<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\View\View;

class Checkbox extends FormComponent
{
    public string $uniqueKey;

    public string $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public ?string $width = 'full', public ?string $dependOn = null, public ?string $dependOnType = null)
    {
        $this->uniqueKey = parent::generateUniqueKey();
        $this->css = parent::getConfigClasses(parent::getThemeCheckbox());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.checkbox');
    }
}
