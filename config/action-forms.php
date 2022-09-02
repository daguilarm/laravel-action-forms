<?php

use Daguilarm\ActionForms\Components;

return [
    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    */
    'label-color' => 'text-gray-500',
    'element-color' => 'text-gray-400', // Text color for input, textarea,...
    'element-focus' => ['focus:border-gray-500', 'focus:ring-gray-500'], // Border color on focus for input, textarea,...
    'element-placeholder' => 'text-gray-400',
    'helper-color' => 'text-gray-400',
    'error-color' => 'text-red-500',
    'shadow' => false,

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
