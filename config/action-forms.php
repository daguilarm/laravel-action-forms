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
        // Show view
        'show' => [
            'container' => 'w-full flex items-center p-3 text-sm border-b border-gray-100 last:border-0',
            'label' => 'w-1/4 text-gray-400',
            'data' => 'w-3/4 text-cyan-700 font-semibold',
            'after' => 'p-1 text-gray-400 italic text-xs',
        ],
        // Form view
        'form' => 'w-full shadow rounded-md bg-white px-8 py-6',
        'element' => 'block mb-8',
        'disabled' => 'opacity-50',
        'label' => [
            'base' => 'w-full block font-medium text-cyan-700',
            'general' => 'text-base',
            'checkbox' => 'ml-2 text-base',
        ],
        'helper' => 'px-1 mt-1 -mb-1 text-sm text-cyan-800 italic opacity-60',
        // Input and textarea
        'input' => [
            'base' => 'w-full p-2',
            'bg' => 'bg-gray-50',
            'text' => 'text-base text-cyan-700', // Text color for input, textarea,...
            'border' => 'border border-gray-300',
            'focus' => 'focus:outline-none focus:border-cyan-500 focus:ring-cyan-500', // Border color on focus for input, textarea,...
            'disabled' => 'disabled:bg-gray-200 disabled:text-gray-400 disabled:border-gray-300',
            'placeholder' => 'placeholder:text-gray-600 placeholder:italic placeholder:opacity-40',
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
            'base' => 'w-5 h-5 text-cyan-600 bg-cyan-100 rounded border border-cyan-300 ',
            'focus' => 'focus:ring-cyan-500',
            'disabled' => 'disabled:border',
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
    | Components
    |--------------------------------------------------------------------------
    */
    'components' => [

        // Base
        'form' => Components\Form::class,
        'input' => Components\Input::class,
        'textarea' => Components\Textarea::class,
        'checkbox' => Components\Checkbox::class,
        'radio' => Components\Radio::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    */
    'prefix' => '',

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
];
