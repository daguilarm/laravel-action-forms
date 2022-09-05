<?php

namespace Daguilarm\ActionForms;

use Illuminate\View\Component;
use Illuminate\View\View;

abstract class FormComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    abstract public function render(): View;

    /**
     * Package theme: label
     */
    protected function getTheme(): array
    {
        return array_merge(
            self::getThemeLabel(),
            self::getThemeInput(),
            self::getThemeCheckbox(),
            self::getThemeTextarea(),
            self::getThemeMessages(),
        );
    }

    /**
     * Package theme: label
     */
    protected function getThemeLabel(): array
    {
        return [
            'label.text',
        ];
    }

    /**
     * Package theme: helper
     */
    protected function getThemeHelper(): array
    {
        return [
            'helper',
        ];
    }

    /**
     * Package theme: input
     */
    protected function getThemeInput(): array
    {
        return [
            'input.bg',
            'input.text',
            'input.border',
            'input.focus',
            'input.disabled',
            'input.placeholder',
            'input.shadow',
        ];
    }

    /**
     * Package theme: input addons
     */
    protected function getThemeInputAddons(): array
    {
        return [
            'input.addons.text',
            'input.addons.bg',
            'input.addons.border',
        ];
    }

    /**
     * Package theme: checkbox
     */
    protected function getThemeCheckbox(): array
    {
        return [
            'checkbox.base',
            'checkbox.focus',
            'checkbox.label',
        ];
    }

    /**
     * Package theme: textarea
     */
    protected function getThemeTextarea(): array
    {
        return [
            'textarea.counter',
        ];
    }

    /**
     * Package theme: messages
     */
    protected function getThemeMessages(): array
    {
        return [
            'messages.errors.base',
            'messages.errors.border',
        ];
    }

    /**
     * Get the config theme classes
     */
    protected function getConfigClasses(array $list, string $result = ''): string
    {
        // Populate with all the data
        foreach ($list as $element) {
            $result .= config('action-forms.theme.'.$element).' ';
        }

        // Remove duplicate entries
        return trim(implode(' ', array_unique(explode(' ', $result))));
    }

    /**
     * Generate the list of tailwind classes used by the package theme
     */
    protected function safeCssClasses(string $safeList = ''): string
    {
        return self::getConfigClasses(self::getTheme());
    }

    /**
     * Generate an unique key for the component
     */
    protected function generateUniqueKey(): string
    {
        return str()->uuid();
    }
}
