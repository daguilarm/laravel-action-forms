<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Input extends FormComponent
{
    use Configable;

    public string $addons = '';

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public string $width = 'full', public ?string $dependOn = null, public string $dependOnType = 'disabled', public bool $conditional = true, public ?string $helper = null, public ?string $before = null, public ?string $after = null)
    {
        parent::__construct();

        $this->addons = $this->getAddonsClasses();
        $this->css = collect([
            'base' => $this->getConfigClasses($this->getThemeInput()),
            'label' => $this->getConfigClasses($this->getThemeLabel()),
            'addons' => $this->getConfigClasses($this->getThemeInputAddons()),
            'addonsHighlight' => $this->getConfigClasses($this->getThemeInputAddonsHighlight()),
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
        return view('action-forms::components.input');
    }

    /**
     * Generete the custom tailwind class for addons
     */
    private function getAddonsClasses()
    {
        if ($this->after && $this->before) {
            return 'rounded-none';
        }

        if ($this->after) {
            return 'rounded-none rounded-l-md';
        }

        if ($this->before) {
            return 'rounded-none rounded-r-md';
        }

        return 'rounded-md';
    }
}
