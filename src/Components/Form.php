<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;

class Form extends FormComponent
{
    public ?string $section = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $action, public ?string $model = null)
    {
        $this->model = parent::getModel($model);
        $this->section = parent::getSection($model);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('action-forms::components.form');
    }
}
