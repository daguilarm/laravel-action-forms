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

