<?php

use Daguilarm\ActionForms\Components;

return [
    /*
    |--------------------------------------------------------------------------
    | Tailwindcss
    |--------------------------------------------------------------------------
    | Generate a container with all the tailwind used by the theme
    |
    */
    'tailwind-safe-list' => true,

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    */
    'theme' => [
        // Colors
        'colors' => [
            'primary' => 'cyan',
            'secondary' => 'slate',
            'warning' => 'yellow',
            'danger' => 'red',
            'success' => 'green',
        ],
        'color_darkness' => [
            'base' => '500',
            'hover' => '600',
            'border' => '400',
        ],
        // Restore button
        'restore' => 'float-right bg-yellow-500 shadow hover:bg-yellow-600 text-white p-2 -mr-2 rounded-md cursor-pointer',
        // Show view
        'show' => [
            'container' => 'w-full flex items-center p-3 text-sm border-b border-slate-100 last:border-0',
            'label' => 'w-1/4 text-slate-400',
            'data' => 'w-3/4 text-cyan-700 font-semibold',
            'after' => 'p-1 text-slate-400 italic text-xs',
        ],
        // Form view
        'form' => 'w-full shadow rounded-md bg-white px-8 py-6',
        'element' => 'block mb-8',
        'disabled' => 'opacity-40',
        'label' => [
            'base' => 'w-full block font-medium text-cyan-700',
            'general' => 'text-base',
            'checkbox' => 'ml-2 text-base',
            'radio' => 'text-base',
        ],
        'helper' => 'px-1 mt-1 -mb-1 text-sm text-cyan-800 italic opacity-60',
        // Input and textarea
        'input' => [
            'base' => 'w-full p-2',
            'bg' => 'bg-slate-50',
            'text' => 'text-base text-cyan-700', // Text color for input, textarea,...
            'border' => 'border border-slate-300',
            'focus' => 'focus:outline-none focus:border-cyan-500 focus:ring-cyan-500', // Border color on focus for input, textarea,...
            'disabled' => 'disabled:bg-slate-200 disabled:text-slate-300 disabled:border-slate-200',
            'placeholder' => 'placeholder:text-slate-600 placeholder:italic placeholder:opacity-40',
            'shadow' => 'shadow',
            'addons' => [
                'text' => 'text-white',
                'bg' => 'bg-cyan-800',
                'border' => 'border border-cyan-700',
            ],
        ],
        // Textarea elements
        'textarea' => [
            'rounded' => 'rounded-md',
            'counter' => 'py-1.5 w-full italic text-right text-xs text-cyan-700 opacity-70',
        ],
        // Checkbox
        'checkbox' => [
            'base' => 'w-4 h-4 text-cyan-600 bg-cyan-100 rounded border border-cyan-300 accent-cyan-600',
            'focus' => 'focus:ring-cyan-500',
            'disabled' => 'disabled:border',
        ],
        'radio' => [
            'layout' => [
                'horizontal' => 'flex items-center space-x-4 overflow-x-hidden',
                'vertical' => 'block',
            ],
        ],
        // Select
        'select' => [
            'base' => 'block w-full rounded-md border border-slate-200 bg-slate-50 mt-1 py-3 pl-3 pr-10 text-base text-cyan-700 focus:border-cyan-500 focus:outline-none focus:ring-cyan-500',
        ],
        // Button
        'button' => [
            'base' => 'rounded-md py-2 px-4 text-sm font-medium border shadow-sm',
        ],
        // Messages
        'messages' => [
            'errors' => [
                'base' => 'p-1 mt-1',
                'text' => 'text-sm text-red-500 font-semibold',
                'border' => 'border-red-500',
            ],
        ],
        // Empty field
        'empty-field' => '---',
    ],

    /*
    |--------------------------------------------------------------------------
    | Reset and restore disabled fields
    |--------------------------------------------------------------------------
    | reset_disabled: When you are using dependent field, if the parent is disabled the child will be disabled and reset.
    | restore_disabled: Will show a restore button for the disabled (and reset) values.
    */
    'reset_disabled' => true,
    'restore_disabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Javascript CDNs
    |--------------------------------------------------------------------------
    */
    'cdn' => [
        'javascript' => [
            'alpinejs' => 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js',
            'tailwind' => 'https://cdn.tailwindcss.com',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Components prefix
    |--------------------------------------------------------------------------
    | By default the component will be like thid: <x-form></x-form>
    | You can custom the component like: <x-mycustom-form></x-mycustom-form>
    */
    'components_prefix' => '',
];
