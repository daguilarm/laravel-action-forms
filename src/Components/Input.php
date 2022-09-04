<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\View\View;

class Input extends FormComponent
{
    public string $addons = '';

    public string $uniqueKey;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public ?string $width = 'full', public ?string $dependOn = null, public ?string $dependOnType = null, public bool $before = false, public bool $after = false)
    {
        $this->addons = match (true) {
            $after && $before => 'rounded-none',
            $after => 'rounded-none rounded-l-md',
            $before => 'rounded-none rounded-r-md',
            default => 'rounded-md',
        };

        $this->uniqueKey = parent::generateUniqueKey();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.input');
    }
}
