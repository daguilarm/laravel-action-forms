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


/**
 * Render the javacript
 */
if (! function_exists('af__js_filter')) {
    function af__render_js(string $key, string $value): string
    {
        return sprintf('%s=%s', af__js_filter($key), af__js_filter($value));
    }
}

/**
 * Javascript filter
 */
if (! function_exists('af__js_filter')) {
    function af__js_filter(string $value): string
    {
        return str_replace(['`', '\\', '#'], '"', $value);
    }
}