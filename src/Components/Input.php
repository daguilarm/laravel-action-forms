<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Input extends FormComponent
{
    public string $addons = '';

    public string $uniqueKey;

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $label = null, public ?string $width = 'full', public ?string $dependOn = null, public ?string $dependOnType = null, public ?string $before = null, public ?string $after = null)
    {
        $this->addons = self::getAddonsClasses();
        $this->uniqueKey = parent::generateUniqueKey();
        $this->css = collect([
            'base' => parent::getConfigClasses(parent::getThemeInput()),
            'label' => parent::getConfigClasses(parent::getThemeLabel()),
            'addons' => parent::getConfigClasses(parent::getThemeInputAddons()),
            'addonsHighlight' => parent::getConfigClasses(parent::getThemeInputAddonsHighlight()),
            'error' => parent::getConfigClasses(parent::getThemeErrorMessages()),
            'errorHighlight' => parent::getConfigClasses(parent::getThemeErrorMessagesHighlight()),
            'helper' => parent::getConfigClasses(parent::getThemeHelper()),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.input');
    }

    /**
     * Generete the custom tailwind class for addons
     */
    private function getAddonsClasses()
    {
        if ($this->after && $this->before) {
            return 'rounded-none';
        }

        if ($this->after) {
            return 'rounded-none rounded-l-md';
        }

        if ($this->before) {
            return 'rounded-none rounded-r-md';
        }

        return 'rounded-md';
    }
}
