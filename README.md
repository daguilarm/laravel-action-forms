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
- https://flatpickr.js.org/getting-started/

If you prefer, you can add this requirements using CDN. We have created a few **Blade Directives** in order to help you. You can add this **Blade Directives** between your `<head></head>`:

```html
<!-- This will add all the needed CDNs into your Blade template. -->
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

```html
<!-- This will add the flatpickr CDN into your Blade template. -->
@ActionFormsFlatpickr
```

If you are using `PostCss` in your Tailwindcss configuration, you will need to add the following line in your `tailwind.config.js`:

```js
module.exports = {
    content: [
        ...
        './vendor/daguilarm/laravel-action-forms/resources/views/**/*.php',
    ],
```

With this, when `PostCss` scans the all package views it will find a hidden tag (`<span class="hidden ..."></span>`) containing all the classes used by the package (disable this feature if you are not using `PostCss`). You can disable this feature in the config file:

```js
/*
|--------------------------------------------------------------------------
| Tailwindcss
|--------------------------------------------------------------------------
| Generate a container with all the tailwind used by the theme
|
*/
'tailwind-safe-list' => false,
```

> Remember: if you are using `tailwind-safe-list`, you will need to clear views each time you change something in the package theme.

You can also modify the package theme, using the config file:

```js
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
```

For this you need to publish the configuration file:

```bash
php artisan vendor:publish --provider="Daguilarm\ActionForms\CookieConsentServiceProvider"
```

## Important!

- In order to eliminate problems, always add an `id` attribute to each component.
- Don't use all the dependencies. Each component will inform you of the dependencies it requires. **Only tailwindcss is required for all the components**.

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

> This component requires the **alpinejs** dependency.

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

> This component requires the **alpinejs** dependency.

```html
<x-form>
    <x-textarea
        width="w-1/3"
        name="description"
        label="Description"
        placeholder="description..."
        maxlength="300"
        :count="true"
        rows="10"
        required
    />
</x-form>
```

An `textarea` field, has also a list of custom parameters like:

### label 

It works the same way as explained in the `input` field.

### width 

It works the same way as explained in the `input` field.

### helper 

It works the same way as explained in the `input` field.

### dependOn & dependOnType

It works the same way as explained in the `input` field.

### maxlength 

It is used to determine the maximum number of characters allowed. By default it will be 220.

### count 

This field only admits boolean values. It is used to indicate if we want to show the characters used and the remaining characters. By default it is disabled.

### rows 

Indicates the default number of rows that the textarea will have. The default value is 4.

## Checkbox 
working on it...

## Radio 
## File 
## Select 
## Datalist (alpinejs)
## Datetime (flatpickr) 
## Combobox (alpinejs)