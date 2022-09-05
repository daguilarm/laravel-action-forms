<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewResponse;

class Form extends FormComponent
{
    public string $safeCssClasses = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $action, public string $method, public string $view, public ?object $data)
    {
        // Create the form binding
        View::composer('action-forms::*', function ($template) {
            $template
                ->with('data', isset($this->data) ? json_decode($this->data) : null)
                ->with('viewAction', $this->view);
        });

        $this->safeCssClasses = parent::safeCssClasses();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): ViewResponse
    {
        return view('action-forms::components.form');
    }
}
