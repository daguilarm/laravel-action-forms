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
        'label' => [
            'text' => 'text-base text-gray-500 font-medium',
        ],
        'helper' => 'px-1 mt-1 -mb-1 text-sm text-gray-400 italic',
        // Input and textarea
        'input' => [
            'bg' => 'bg-white',
            'text' => 'text-base text-gray-500', // Text color for input, textarea,...
            'border' => 'border-gray-200',
            'focus' => 'focus:border-gray-500 focus:ring-gray-500', // Border color on focus for input, textarea,...
            'disabled' => 'disabled:bg-gray-200 disabled:text-gray-400 disabled:border-gray-300',
            'placeholder' => 'placeholder:text-gray-300 placeholder:italic',
            'addons' => [
                'text' => 'text-gray-50',
                'bg' => 'bg-gray-400',
                'border' => 'border border-gray-400',
            ],
            'shadow' => 'shadow',
        ],
        // Textarea elements
        'textarea' => [
            // 'rounded' => 'rounded-md',
            'counter' => 'py-1.5 w-full italic text-right text-sm text-gray-400',
        ],
        'checkbox' => [
            'base' => 'w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 ',
            'focus' => 'focus:ring-blue-500',
            'label' => 'ml-2 text-sm text-gray-900 font-medium',
        ],
        'messages' => [
            'errors' => [
                'base' => 'p-1 mt-1 text-sm text-red-500 font-semibold',
                'border' => 'border-red-500',
            ],
        ],
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
