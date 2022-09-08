<?php

namespace Daguilarm\ActionForms\Components;

use Illuminate\View\View;
use Illuminate\Support\Collection;
use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;

class Radio extends FormComponent
{
    use Configable;

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public ?string $width = 'full', public ?string $dependOn = null, public ?string $dependOnType = null, public bool $conditional = true, public bool $asBoolean = false, public array $options = [])
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
        return view('action-forms::components.radio');
    }
}
