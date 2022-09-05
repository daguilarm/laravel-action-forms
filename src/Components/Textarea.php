<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\View\View;

class Textarea extends FormComponent
{
    public string $uniqueKey;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public ?string $width = 'full', public int $maxlength = 220, public int $rows = 4, public ?string $dependOn = null, public ?string $dependOnType = null, public ?string $counter = null)
    {
        $this->counter = !is_null($counter) ? true : false;
        $this->uniqueKey = parent::generateUniqueKey();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.textarea');
    }
}
