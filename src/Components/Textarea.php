<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;

class Textarea extends FormComponent
{
    public string $addons = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public ?string $width = 'full', public ?string $dependOn = null, public ?int $count = null)
    {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('action-forms::components.textarea');
    }
}
