<?php

namespace Daguilarm\ActionForms;

use Illuminate\View\Component;
use Illuminate\View\View;

abstract class FormComponent extends Component
{
    public string $uniqueKey = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->uniqueKey = $this->generateUniqueKey();
    }

    /**
     * Get the view / contents that represent the component.
     */
    abstract public function render(): View;

    /**
     * Generate an unique key for the component
     */
    protected function generateUniqueKey(): string
    {
        return md5(str()->uuid()->toString());
    }
}
