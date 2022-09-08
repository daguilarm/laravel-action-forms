<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Checkbox extends FormComponent
{
    use Configable;

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public string $width = 'full', public ?string $dependOn = null, public string $dependOnType = 'disabled', public bool $conditional = true, public ?string $helper = null, public bool $asBoolean = false)
    {
        parent::__construct();
        
        $this->asBoolean = $asBoolean ? true : false;
        $this->css = collect([
            'base' => $this->getConfigClasses($this->getThemeCheckbox()),
            'label' => $this->getConfigClasses($this->getThemeCheckboxLabel()),
            'error' => $this->getConfigClasses($this->getThemeErrorMessages()),
            'errorHighlight' => $this->getConfigClasses($this->getThemeErrorMessagesHighlight()),
            'helper' => $this->getConfigClasses($this->getThemeHelper()),
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
