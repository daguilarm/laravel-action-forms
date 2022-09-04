# laravel-action-forms (project in development...)
 A package to manage forms with Laravel, using only one blade file for all your views (create, edit and show). You will only need to create a file with your form (only once), and the package will automatically generate the views to create, edit and show.

## Install 

```bash
composer require daguilarm/laravel-action-forms
```

## Requirements and configuration

This package use:

- https://tailwindcss.com/docs/installation
- https://alpinejs.dev/essentials/installation

If you prefer, you can add this requirements using CDN. We have created a few **Blade Directives** in order to help you. You can add this **Blade Directives** between your `<head></head>`:

```html
<!-- This will add the two CDNs into your Blade template. -->
@ActionForms
```

```html
<!-- This will add the alpinejs CDN into your Blade template. -->
@ActionFormsAlpine
```

```html
<!-- This will add the tailwindcss CDN into your Blade template. -->
@ActionFormsTailwind
```

You have to add to your tailwind.config.js the next lines:

```js
module.exports = {
    content: [
        ...
        './vendor/daguilarm/laravel-action-forms/resources/views/components/*.php',
        './vendor/daguilarm/laravel-action-forms/resources/views/elements/*.php',
        './vendor/daguilarm/laravel-action-forms/config/*.php',
    ],
```

You can modify the package theme, using the config file:

```js
/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
*/
'theme' => [
    'label' => [
        'text' => 'text-gray-500',
    ],
    'input' => [
        'bg' => 'bg-gray-50',
        'text' => 'text-gray-400', // Text color for input, textarea,...
        'focus' => 'focus:border-gray-500 focus:ring-gray-500', // Border color on focus for input, textarea,...
        'placeholder' => 'text-gray-400',
        'helper' => 'text-gray-400',
        'addons' => 'bg-gray-200 text-gray-400',
        'shadow' => false,
    ],
    'messages' => [
        'errors' => [
            'text' => 'text-red-500',
        ]
    ],
],
```

For this you need to publish the configuration file:

```bash
php artisan vendor:publish --provider="Daguilarm\ActionForms\CookieConsentServiceProvider"
```

Maybe you will need to add your `theme` configuration to your `tailwind.config.js` safe-list:

```js
// This are the default values used by the package
safelist: [
    'text-sm text-base text-white text-gray-400 text-gray-500 text-red-500 font-semibold font-medium bg-white bg-gray-400 border border-gray-200 border-gray-400 border-red-500 italic shadow focus:border-gray-500 focus:ring-gray-500 placeholder:text-gray-300 placeholder:italic',
],
```

## Important!

In order to eliminate problems, always add an `id` attribute to each component.

## Create a form 

```html
<x-form
    id="form"
    method="post"
    action="/users/update"
    data="\App\Models\User::find(3)"
    view="show"
>
    ...
</x-form>
```

An `form` field, has also a list of custom parameters like:

### data 

It is the current model result. You have to pass the data for model binding.

### view

It is the current view action: `edit`, `create` or `show`. This is for render the custom view for each action. The truth is that it is only necessary to indicate it when the view is `show`.

### method

The soported methods for the form are:

- **post**: Is the default value if you keep this attribute empty. Will send a `POST` `_method` to **Laravel**.
- **get**: Will send a `GET` `_method` to **Laravel**.
- **update** and **edit**: Will send a `PATCH` `_method` to **Laravel**. You can use either.
- **delete** and **destroy**: Will send a `DELETE` `_method` to **Laravel**. You can use either.

## Input

The `input` field use all the supported parameters, like: `type`, `name`, `placehoder`, `required`, etc... The basic example of an `input` field will be:

```html
<x-form>
    <x-input
        id="name"
        type="text"
        width="1/2"
        name="name"
        label="My name"
        placehoder="..."
        helper="This is a way to explain something..."
        class="p-2"
        required
    />
</x-form>
```

An `input` field, has also a list of custom parameters like:

### label 

Will render a `<label>` tag like: `<label>My name</label/>`.

### width 

The `width` parameter allow you to set the container width using **tailwindcss** styles like: `w-1/2`, `w-2/3`,... If you remove the `width` parameter, the default value will be `w-full`.

### helper 

Will show a helper message after the input.

### dependOn & dependOnType

This will allow us to create dependent fields, for example:

```html
<x-form>
    <x-input
        id="name"
        type="text"
        name="name"
        label="My name"
        required
    />
    <x-input
        id="surname"
        type="text"
        name="surname"
        label="Surname"
        dependOn="name"
        dependOnType="hidden" // or dependOnType="disabled"
        required
    />
</x-form>
```

In this case, the `surname` field will be hidden until the `name` field has a value. The system will be watching the `name` field until an `onchange` event occurs, and then it will check if the `name` field is still empty, if not, it will display the `surname` field. 

The `dependOnType()` attribute admits two possible values: `hidden` or `disabled`.

### addons 

You can add addons before, after or both. At the moment, it only supports text. In the future it will support icons.

```html
<x-form>
    <x-input
        id="url"
        type="text"
        name="url"
        before="http://"
    />
    <x-input
        id="email"
        type="text"
        name="email"
        after="@"
    />
    <x-input
        id="price"
        type="text"
        name="price"
        before="$"
        after="USD"
    />
</x-form>
```

## Textarea 
## Select 
## Checkbox 
## Radio 
## Datalist
## File 
## Datetime (flatpickr) 
## Combobox 