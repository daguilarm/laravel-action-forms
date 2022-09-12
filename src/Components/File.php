<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class File extends FormComponent
{
    use Configable;

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?string $label = null,
        public string $width = 'full',
        public ?string $dependOn = null,
        public ?bool $conditional = true,
        public ?string $helper = null,
    ) {
        parent::__construct();

        $this->css = collect([
            'base' => $this->getConfigClasses($this->getThemeFile()),
            'label' => $this->getConfigClasses($this->getThemeCheckboxLabel()),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.file');
    }
}
