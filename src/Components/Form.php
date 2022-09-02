<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Facades\View;

class Form extends FormComponent
{
    public ?string $section = null;

    public string $formId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $action, protected ?string $model = null, public ?string $key = null)
    {
        // Get the model instance and the current section
        $this->model = parent::getModel($model, $key);
        $this->section = parent::getSection($model);
        $this->formId = parent::getKey($model, $key);

        // Create the form binding
        View::composer('action-forms::*', function($view) {
            $view->with('modelBinding', json_decode($this->model));
        });
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
