<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Textarea extends FormComponent
{
    use Configable;

    public string $uniqueKey;

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public ?string $width = 'full', public ?string $dependOn = null, public ?string $dependOnType = null, public bool $conditional = true, public int $maxlength = 220, public int $rows = 4, public ?string $counter = null)
    {
        $this->counter = ! is_null($counter) ? true : false;
        $this->uniqueKey = $this->generateUniqueKey();
        $this->css = collect([
            'base' => $this->getConfigClasses($this->getThemeTextarea()),
            'label' => $this->getConfigClasses($this->getThemeLabel()),
            'counter' => $this->getConfigClasses($this->getThemeTextareaCounter()),
            'error' => $this->getConfigClasses($this->getThemeErrorMessages()),
            'errorHighlight' => $this->getConfigClasses($this->getThemeErrorMessagesHighlight()),
            'helper' => $this->getConfigClasses($this->getThemeHelper()),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.textarea');
    }
}
