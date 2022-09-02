<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Facades\View;

class Form extends FormComponent
{
    public ?string $section = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $action, protected ?string $model = null, public ?string $id = null)
    {
        $this->model = parent::getModel($model, $id);
        $this->section = parent::getSection($model);

        View::share('modelBinding', json_decode($this->model));
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
