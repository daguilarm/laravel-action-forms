<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Checkbox extends FormComponent
{
    public string $uniqueKey;

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public ?string $width = 'full', public ?string $dependOn = null, public ?string $dependOnType = null)
    {
        $this->uniqueKey = parent::generateUniqueKey();
        $this->css = collect([
            'base' => parent::getConfigClasses(parent::getThemeCheckbox()),
            'label' => parent::getConfigClasses(parent::getThemeCheckboxLabel()),
            'error' => parent::getConfigClasses(parent::getThemeErrorMessages()),
            'errorHighlight' => parent::getConfigClasses(parent::getThemeErrorMessagesHighlight()),
            'helper' => parent::getConfigClasses(parent::getThemeHelper()),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.checkbox');
    }
}
