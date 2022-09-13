<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\View\View;

class Group extends FormComponent
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?string $position = 'horizontal',
        public string $align = 'right',
        public string $width = 'full',
    ) {
        parent::__construct();

        if ($position) {
            $positionAlign = match ($align) {
                'left' => 'justify-start',
                'center' => 'justify-center',
                'right' => 'justify-end',
            };
            $this->position = match ($position) {
                'horizontal' => 'flex items-center ' . $positionAlign . ' space-x-4',
                'vertical' => 'flex flex-col space-y-4'
            };
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.group', [
            'css' => $this->position,
        ]);
    }
}
