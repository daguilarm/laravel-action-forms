<?php

namespace Daguilarm\ActionForms;

use Illuminate\View\Component;

abstract class FormComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    abstract public function render();

    protected function safeCssClasses(string $safeList = '') {
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
            'messages.errors.text',
            'messages.errors.border',
        ];

        foreach($themeList as $element) {
            $safeList .= config('action-forms.theme.' . $element) . ' ';
        }

        return trim($safeList);
    }
}
