<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Toggle extends FormComponent
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
        public string $dependOnType = 'disabled',
        public mixed $dependOnValue = null,
        public ?bool $conditional = null,
        public ?string $helper = null,
        public ?string $color = 'success',
    ) {
        parent::__construct();

        $this->css = collect([
            'base' => $this->getConfigClasses($this->getThemeButton()),
            'label' => $this->getConfigClasses($this->getThemeLabel()),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.toggle');
    }
}
