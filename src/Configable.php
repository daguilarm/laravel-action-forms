<?php

namespace Daguilarm\ActionForms;

trait Configable
{
    /**
     * Package theme: restore button
     */
    protected function getThemeRestore(): array
    {
        return [
            'restore',
        ];
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
     * Package theme: select
     */
    protected function getThemeSelect(): array
    {
        return [
            'select.base',
        ];
    }

    /**
     * Package theme: label for radio
     */
    protected function getThemeRadioLabel(): array
    {
        return [
            'label.base',
            'label.radio',
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
     * Package theme: file
     */
    protected function getThemeFile(): array
    {
        return [
            'file.base',
        ];
    }

    /**
     * Package theme: button
     */
    protected function getThemeButton(): array
    {
        return [
            'button.base',
        ];
    }

    /**
     * Package theme: button
     */
    protected function getThemeButtonColor(): string
    {
        return collect(config('action-forms.theme.colors'))
            ->map(function ($value, $key) {
                return 'bg-' . $value . '-600 hover:bg-' . $value . '-700 border-' . $value . '-400';
            })
            ->implode(' ');
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
     * Package theme: disabled
     */
    protected function getThemeDisabled(): array
    {
        return [
            'disabled',
        ];
    }

    /**
     * Get the config theme classes
     */
    protected function getConfigClasses(array $list, string $result = ''): string
    {
        // Populate with all the data
        foreach ($list as $element) {
            $result .= config('action-forms.theme.' . $element) . ' ';
        }

        // Remove duplicate entries
        return trim(implode(' ', array_unique(explode(' ', $result))));
    }
}
