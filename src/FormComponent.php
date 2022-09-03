<?php

namespace Daguilarm\ActionForms;

use Illuminate\View\Component;

abstract class FormComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    abstract public function render();
}
