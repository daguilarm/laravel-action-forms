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

The soported methods for the form are:

- **post**: Is the default value if you keep this attribute empty. Will send a `POST` `_method` to **Laravel**.
- **get**: Will send a `GET` `_method` to **Laravel**.
- **update** and **edit**: Will send a `PATCH` `_method` to **Laravel**. You can use either.
- **delete** and **destroy**: Will send a `DELETE` `_method` to **Laravel**. You can use either.

## Create a input field

The `input` field use all the supported parameters, like: `type`, `name`, `placehoder`, `required`, etc... The basic example of an `input` field will be:

```
<x-form>
    <x-input
        type="text"
        width="1/2"
        name="name"
        label="My name"
        placehoder="..."
        class="p-2"
        required
    />
</x-form>
```

An `input` field, has also a list of custom parameters like:

### Label 

Will render a `<label>` tag like: `<label>My name</label/>`.

### Width 

The `width` parameter allow you to set the container width using **tailwindcss** styles like: `w-1/2`, `w-2/3`,... If you remove the `width` parameter, the default value will be `w-full`.