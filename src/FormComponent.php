<?php

namespace Daguilarm\ActionForms;

use Illuminate\View\View;
use Illuminate\View\Component;

abstract class FormComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    abstract public function render(): View;

    /**
     * Generate the list of tailwind classes used by the package theme
     */
    protected function safeCssClasses(string $safeList = '') {
        // All the theme values
        $themeList = [
            'label.text',
            'input.bg',
            'input.text',
            'input.border',
            'input.focus',
            'input.placeholder',
            'input.shadow',
            'input.helper',
                'input.addons.text',
                'input.addons.bg',
                'input.addons.border',
            'textarea.counter',
            'messages.errors.text',
            'messages.errors.border',
        ];

        // Populate with all the data
        foreach($themeList as $element) {
            $safeList .= config('action-forms.theme.' . $element) . ' ';
        }

        // Remove duplicate entries
        return trim(implode(' ', array_unique(explode(' ', $safeList))));
    }

    /**
     * Generate an unique key for the component 
     */
    protected function generateUniqueKey(): string
    {
        return str()->uuid();
    }
}
