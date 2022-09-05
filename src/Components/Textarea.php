<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewResponse;

class Textarea extends FormComponent
{
    public string $uniqueKey;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public ?string $width = 'full', public int $maxlength = 220, public int $rows = 4, public ?string $dependOn = null, public ?string $dependOnType = null, public bool $count = false)
    {
        $this->uniqueKey = parent::generateUniqueKey();

        // Set the element type
        View::composer('action-forms::*', function ($template) {
            $template
                ->with('elementType', 'input');
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): ViewResponse
    {
        return view('action-forms::components.textarea');
    }
}
