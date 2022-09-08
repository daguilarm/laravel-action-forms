<?php

namespace Daguilarm\ActionForms;

trait Configable
{
    /**
     * Package theme: label
     */
    protected function getTheme(): array
    {
        return array_merge(
            self::getThemeShow(),
            self::getThemeElement(),
            self::getThemeForm(),
            self::getThemeLabel(),
            self::getThemeInput(),
            self::getThemeHelper(),
            self::getThemeCheckbox(),
            self::getThemeCheckboxLabel(),
            self::getThemeTextarea(),
            self::getThemeInputAddons(),
            self::getThemeInputAddonsHighlight(),
            self::getThemeErrorMessages(),
            self::getThemeErrorMessagesHighlight(),
        );
    }

    /**
     * Package theme: show
     */
    protected function getThemeShow(): array
    {
        return [
            'show.container',
            'show.label',
            'show.data',
            'show.after',
        ];
    }

    /**
     * Package theme: form
     */
    protected function getThemeForm(): array
    {
        return [
            'form',
        ];
    }

    /**
     * Package theme: element
     */
    protected function getThemeElement(): array
    {
        return [
            'element',
        ];
    }

    /**
     * Package theme: label
     */
    protected function getThemeLabel(): array
    {
        return [
            'label.base',
            'label.general',
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
            'input.base',
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
            'input.shadow',
        ];
    }

    /**
     * Package theme: input addons
     */
    protected function getThemeInputAddonsHighlight(): array
    {
        return [
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
            'checkbox.disabled',
        ];
    }

    /**
     * Package theme: label for checkbox
     */
    protected function getThemeCheckboxLabel(): array
    {
        return [
            'label.base',
            'label.checkbox',
        ];
    }

    /**
     * Package theme: textarea
     */
    protected function getThemeTextarea(): array
    {
        return array_merge(
            self::getThemeInput(),
            [
                'textarea.rounded',
            ]
        );
    }

    /**
     * Package theme: textarea
     */
    protected function getThemeTextareaCounter(): array
    {
        return [
            'textarea.counter',
        ];
    }

    /**
     * Package theme: messages
     */
    protected function getThemeErrorMessages(): array
    {
        return [
            'messages.errors.text',
            'messages.errors.border',
        ];
    }

    /**
     * Package theme: messages
     */
    protected function getThemeErrorMessagesHighlight(): array
    {
        return [
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
        return self::getConfigClasses(self::getTheme())
            .' '.config('action-forms.theme.disabled')
            .' w-4 h-4 rounded-full bg-green-500 bg-gray-400';
    }
}