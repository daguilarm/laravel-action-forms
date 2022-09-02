# action-forms
 A package to manage forms with Laravel, using only one blade file for all your views (index, edit and show).

## Install 

```
composer require daguilarm/laravel-action-forms
```

## Requirements 

This package use:

- https://tailwindcss.com/docs/installation
- https://alpinejs.dev/essentials/installation

If you prefer, you can add this requirements using CDN, and we have created a few **Blade Directives** in order to help you. You can add this **Blade Directives** between your `<head></head>`:

```
# This will add the two CDNs into your Blade template.
@ActionForms
```

```
# This will add the alpinejs CDN into your Blade template.
@ActionFormsAlpine
```

```
# This will add the tailwindcss CDN into your Blade template.
@ActionFormsTailwind
```

You have to add to your tailwind.config.js the next line:

``` 
module.exports = {
    content: [
        ...
        './vendor/laravel-action-forms/resources/views/**/*.php',
    ],
```

## Create a form 
```
<x-form
    id="form"
    method="post"
    action="/users/update"
    model="\App\Models\User"
    key="2"
>
    ...
</x-form>
```

## Create a input field
```
<x-form>
    <x-input
        type="text"
        width="1/2"
        name="name"
        label="My name"
        class="p-2"
        required
    />
</x-form>
```

The `width` parameter support the next values: `1/5`, `1/4`, `1/3`, `1/2`. And if you remove the parameter, the width will be 100%.