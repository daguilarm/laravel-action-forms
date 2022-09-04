<?php

use Daguilarm\ActionForms\Components;

return [
    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    */
    'theme' => [
        'label' => [
            'text' => 'text-base text-gray-500 font-medium',
        ],
        'input' => [
            'bg' => 'bg-white',
            'text' => 'text-base text-gray-500', // Text color for input, textarea,...
            'border' => 'border-gray-200',
            'focus' => 'focus:border-gray-500 focus:ring-gray-500', // Border color on focus for input, textarea,...
            'placeholder' => 'placeholder:text-gray-300 placeholder:italic',
            'helper' => 'text-sm text-gray-400 italic',
            'addons' => [
                'text' => 'text-white',
                'bg' => 'bg-gray-400',
                'border' => 'border border-gray-400',
            ],
            'shadow' => 'shadow',
        ],
        'messages' => [
            'errors' => [
                'text' => 'text-sm text-red-500 font-semibold',
                'border' => 'border-red-500',
            ]
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
