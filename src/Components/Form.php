<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewResponse;

class Form extends FormComponent
{
    public string $safeCssClasses = '';

    public Collection $css;

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
                ->with('viewAction', $this->view)
                ->with('cssElement', config('action-forms.theme.element'));
        });

        $this->safeCssClasses = parent::safeCssClasses();

        $this->css = collect([
            'base' => parent::getConfigClasses(parent::getThemeForm()),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): ViewResponse
    {
        return view('action-forms::components.form');
    }
}
