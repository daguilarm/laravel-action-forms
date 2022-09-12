<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Button extends FormComponent
{
    use Configable;

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $text,
        public string $type = 'submit',
        public string $color = 'primary',
        public array $javascript = [],
    ) {
        parent::__construct();

        $this->css = collect([
            'base' => $this->getConfigClasses($this->getThemeButton()),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.button');
    }
}
