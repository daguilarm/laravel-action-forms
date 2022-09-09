<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Textarea extends FormComponent
{
    use Configable;

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?string $label = null,
        public string $width = 'full',
        public ?string $dependOn = null,
        public string $dependOnType = 'disabled',
        public mixed $dependOnValue = null,
        public ?bool $conditional = null,
        public ?string $helper = null,
        public int $maxlength = 220,
        public int $rows = 4,
        public ?string $counter = null
    ) {
        parent::__construct();

        $this->counter = ! is_null($counter) ? true : false;
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
