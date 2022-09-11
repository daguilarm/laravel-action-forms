<?php

declare(strict_types=1);

use Illuminate\View\ComponentAttributeBag;

/**
 * Get the old data
 */
if (! function_exists('af__value')) {
    function af__value(ComponentAttributeBag $attributes, string $name, ?object $data = null): mixed
    {
        $key = $attributes->get($name);

        return old($name, $data->{$key} ?? null);
    }
}