# laravel-action-forms (project in development...)
 A package to manage forms with Laravel, using only one blade file for all your views (create, edit and show). You will only need to create a file with your form (only once), and the package will automatically generate the views to `create`, `edit` and `show`.

With this example:

```html
<x-form
    id="form-example"
    method="create"
    :action="route('dashboard.users.store')"
    :view="$config->get('action')"
    :data="$data ?? null"
>
    <x-input
        before="Sr/Sra"
        type="text"
        width="w-1/3"
        name="name"
        label="Name"
        placeholder="Your name..."
        helper="Enter your name"
        required
    />
    <x-select
        width="w-1/3"
        name="country"
        label="Select country"
        :options="[
            0 => 'Spain',
            1 => 'Portugal',
            2 => 'France',
            3 => 'Italy',
        ]"
        helper="Select your country..."
    />
    <x-search
        width="w-1/3"
        name="country"
        label="Select user"
        requestFrom="https://test.com/api/user?query="
        requestId="id"
        requestValue="name"
    />
    <x-file
        width="w-1/3"
        name="file"
        label="Select file"
    />
    <x-checkbox
        width="w-1/3"
        name="active"
        label="Active"
        :checked="true"
        :asBoolean="true"
        value="1"
        required
    />
    <x-radio
        width="w-1/3"
        name="role"
        label="Role"
        position="horizontal"
        :options="[
            0 => 'Root',
            1 => 'Admin',
            2 => 'Editor',
            3 => 'User',
            4 => 'Guest',
        ]"
    />
    <x-textarea
        width="w-1/3"
        name="address"
        label="Address"
        placeholder="Your Address..."
        counter
        required
    />
    <x-toggle
        width="w-1/3"
        name="is_admin"
        label="Is admin?"
        color="danger"
        required
    />
    <x-group
        align="right"
        width="w-1/3"
    >
        <x-button
            text="Cancel"
            type="button"
            color="danger"
            :javascript="[
                '@click' => 'console.log(`hellow`)',
                '@change' => 'this.change($el)',
            ]"
        />
        <x-button
            text="Submit"
            type="submit"
            color="success"
        />
    </x-group>
</x-form>
```

Will get this:

![Laravel Action Forms package](./resources/img/laravel-action-forms.gif?raw=true)

## Index
- [Install](#install)
- [Requirements and configuration](#requirements-and-configuration)
- [The show view](#the-show-view)
- [Form](#create-a-form-component)
    - [Attribute: data](#data)
    - [Attribute: view](#view)
    - [Attribute: method](#method)
- [Default attributes for all the components](#default-attributes-for-all-the-components)
    - [Attribute: label](#label)
    - [Attribute: width](#width)
    - [Attributes: dependOn, dependOnType and dependOnValue](#)
    - [Attribute: conditional](#conditional)
    - [Attribute: helper](#helper)
- [Input](#create-an-input-component)
- [Textarea](#create-a-textarea-component)
- [Checkbox](#create-a-checkbox-component)
- [Radio button](#create-a-radio-component)
- [Select](#select)
- [File](#file)
- [Search / Datalist](#search--select-with-search)
- [Button](#button)
- [Element group](#groups)
- [Roadmap](#roadmap)

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

```php
<!-- This will add all the needed CDNs into your Blade template. -->
@ActionForms
```

```php
<!-- This will add the alpinejs CDN into your Blade template. -->
@ActionFormsAlpine
```

```php
<!-- This will add the tailwindcss CDN into your Blade template. -->
@ActionFormsTailwind
```

```php
<!-- This will add the flatpickr CDN into your Blade template. -->
@ActionFormsFlatpickr
```

At the end of your `<body>` tag, add the stack for the scritps:

```php
@stack('action-forms-scripts')
```

If you are using `PostCss` in your Tailwindcss configuration, you will need to add the following lines in your `tailwind.config.js`:

```js
module.exports = {
    content: [
        ...
        './vendor/daguilarm/laravel-action-forms/resources/views/**/*.php',
        './vendor/daguilarm/laravel-action-forms/config/*.php',
    ],
```

With this, when `PostCss` will scan all package and it will discover all classes used. You have also a file in `config/action-forms-tailwind-safe.php` where you can add your tailwind safe list, in case you need it. This is useful if you are using conditional clases in your blade templates:

```js
// Tailwind Safe list
return [
    'border border-slate-400 border-red-400 border-yellow-400 border-cyan-400 border-green-400',
    'text-white',
    'w-4 h-4',
    'rounded-md rounded-full',
    'bg-slate-500 bg-red-500 bg-yellow-500 bg-cyan-500 bg-green-500',
    'hover:bg-slate-600 hover:bg-red-600 hover:bg-yellow-600 hover:bg-cyan-600 hover:bg-green-600',
    'flex items-center justify-start justify-end justify-center',
    'space-x-4 space-y-4',
    'w-1/5 w-1/4 w-1/3 w-2/5 w-1/2 w-3/5 w-2/3 w-3/4 w-4/5 w-11/12 w-full',
];
```

> Remember: if you are using `action-forms-tailwind-safe`, you will need to clear views each time you change something in the package theme.

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

> In the config file, you will find a lot of configuration options.

For this you need to publish the configuration file:

```bash
php artisan vendor:publish --provider="Daguilarm\ActionForms\CookieConsentServiceProvider"
```

## Important!

- In order to eliminate problems, always add an `id` attribute to each component.
- Don't use all the dependencies. Each component will inform you of the dependencies it requires.

## The show view 

The show view is used to display the content of the form, but without using its elements.

**Show view without boolean fields:**

![Show action](./resources/img/show-no-boolean.png?raw=true)

**Show view with boolean fields:**

![Show action with boolean](./resources/img/show-boolean.png?raw=true)

## Create a Form component 

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

It is the current view action: `edit`, `create` or `show`. This is just for render the custom view for each action. **It is a very important attribute.**

### method

The soported methods that can be used in the form are:

- **post**: Is the default value if you keep this attribute empty. Will send a `POST` `_method` to **Laravel**.
- **get**: Will send a `GET` `_method` to **Laravel**.
- **update** and **edit**: Will send a `PATCH` `_method` to **Laravel**. You can use either.
- **delete** and **destroy**: Will send a `DELETE` `_method` to **Laravel**. You can use either.

## Default attributes for all the components

All the components (except `form`) share a series of common methods, apart from those specific to each one of them. Next, we will explain these common methods:

### label 

Will render a `<label>` tag like: `<label>My name</label/>`.

### width 

The `width` parameter allow you to set the container width using **tailwindcss** styles like: `w-1/2`, `w-2/3`,... If you remove the `width` parameter, the default value will be `w-full`. The defult values supported by the package are:

- `w-1/5`: 20%
- `w-1/4`: 25%
- `w-1/3`: 33.33%
- `w-2/5`: 40%
- `w-1/2`: 50% 
- `w-3/5`: 60% 
- `w-2/3`: 66% 
- `w-3/4`: 75% 
- `w-4/5`: 80% 
- `w-11/12`: 91.6%
- `w-full`: 100%

You can add more in the in the file `config/action-forms-tailwind-safe.php`.

### dependOn, dependOnType and dependOnValue

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

**Dependent fields in action:**

![Dependent component](./resources/img/dependOn.gif?raw=true)

**Dependent fields disabled:**

![Dependent component disabled](./resources/img/dependOn-disabled.png?raw=true)

> **The dependent system only works on one level**. That is, a parent element enables or disables their children elements, but it does not trigger a cascade of events towards its own children and these to their children, etc...

### Conditional 

Show or hide a component base on a condition:

    <x-input
        id="surname"
        type="text"
        name="surname"
        label="Surname"
        :conditional="auth()->user()->id === 1"
        required
    />

> If you want to set a default condition, don't forget to send the value as a variable, using the colon character: `:conditional="true"`.

## Create an Input component 

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

### helper 

Will show a helper message after the input.

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

## Create a Textarea component 

> This component requires the **alpinejs** dependency.

```html
<x-form>
    <x-textarea
        width="w-1/3"
        name="description"
        label="Description"
        placeholder="description..."
        maxlength="300"
        rows="10"
        counter
        required
    />
</x-form>
```

An `textarea` field, has also a list of custom parameters like:

### helper 

It works the same way as explained in the `input` field.

### maxlength 

It is used to determine the maximum number of characters allowed. By default it will be 220.

### rows 

Indicates the default number of rows that the textarea will have. The default value is 4.

### counter 

This field is used to indicate if we want to show the characters used and the remaining characters. By default it is disabled.

## Create a Checkbox component 

> This component requires the **alpinejs** dependency.

```html
<x-form>
    <x-checkbox
        type="checkbox"
        width="w-1/3"
        name="active"
        label="Activo"
        dependOn="name"
        :checked="true"
    />
</x-form>
```

### checked 

By default, the field will be unchecked. 

> If you want to set a default value, don't forget to send the value as a variable, using the colon character `:checked="true"`.

## Create a Radio component 

> This component requires the **alpinejs** dependency.

```html
<x-form>
    <x-radio
        width="w-1/3"
        name="role"
        label="Role"
        dependOn="active"
        position="vertical"
        :options="[
            0 => 'Root',
            1 => 'Admin',
            2 => 'Editor',
            3 => 'User',
            4 => 'Guest',
        ]"
    />
</x-form>
```

### position 

You can display the radio button in horizontal or in vertical, using: `position="horizontal"` or `position="vertical"`.

**Radio field with vertical position:**

![Radio button in vertical](./resources/img/radio-vertical.png?raw=true)

**Radio field with horizontal position:**

![Radio button in horizontal](./resources/img/radio-horizontal.png?raw=true)

### options

You will need to add and `array` with the `value` and the `text` to be displayed.

> Don't forget to send the value as a variable, using the colon character `:options="[]"`.

## Select 

```html
<x-select
    width="w-1/3"
    name="country"
    label="Select country"
    :options="[
        0 => 'Spain',
        1 => 'Portugal',
        2 => 'France',
        3 => 'Italy',
    ]"
    default="0"
/>
```

**Select and File examples:**

![Select and File components](./resources/img/select-and-file.png?raw=true)

### options

You will need to add and `array` with the `value` and the `text` to be displayed.

### default 

You can set a default value. This option will be selected by default.

## File 

```html 
<x-file
    width="w-1/3"
    name="file"
    label="Select file"
    dependOn="name"
/>
```

## Search / Select with search 

We can use a component that emulates a `datalist` field but with the option to add values ​​(known problem with `datalist` fields). For this we will use the `Select` component.

This component can use data that comes from an `array` or an `API`. Let's start with an example using an `array`. The first thing is to define the `array`:

```php 
$array = [
    [
        'id' => 1, // key
        'name' => 'Damián', // value
    ],
    [
        'id' => 2, // key
        'name' => 'Daniel', // value
    ],
];
```

The component would look like this (using an `array`):

```html 
<x-search
    width="w-1/3"
    name="country"
    label="Select user"
    :requestFromArray="$array"
    requestId="id"
    requestValue="name"
/>
```

Same case from an `API`:

```html 
<x-search
    width="w-1/3"
    name="country"
    label="Select user"
    requestFrom="https://domain.com/api/user?query="
    requestId="id"
    requestValue="name"
    dependOn="country_id"
/>
```

**Select search / Datalist example:**

![Search component](./resources/img/search.gif?raw=true)

> **Important**: This component contains two input fields, both of which are submitted with the form. Using the example above they would be: `__country` and `country`. The first would send the value of `requestId` and the second the value of `requestValue`.

### requestFromArray 

It use to add the `array` to the component.

### requestFrom 

It use to define the `URL` to the server (in order to get a response). **Only works with `JSON` responses.**

### requestId

Used to define the key of the array.

### requestValue

Used to define the value of the array.

## Toggle 

```html
<x-toggle
    width="w-1/3"
    name="is_admin"
    label="Is admin?"
    color="danger"
    required
/>
```

## color 

The allowed colors are: `primary`, `secondary`, `danger`, `warning` and `success`.

**Toogle button example:**

![Toogle button](./resources/img/toggle.gif?raw=true)

## Button 

You can display different types of buttons on your form, which are easily configurable.

```html
<x-button
    text="Cancel"
    type="button"
    color="danger"
    :javascript="[
        'x-on:click' => 'console.log(`hellow`)',
        'x-on:change' => 'this.change($el)',
    ]"
/>
```

### text

It will the text displayed in the button. In the future will be posible to add icons.

### type

You must define the button type. The supported one are: `submit` and `button`.

### color

The allowed colors are: `primary`, `secondary`, `danger`, `warning` and `success`.

### javascript 

You can customize your buttons with javascript:

```html
<x-button
    :javascript="[
        'x-on:click' => 'console.log(`hello world`)',
        'x-on:change' => 'this.change($el)',
    ]"
/>
```

It will render: 

```html
<button... x-on:click="console.log('hello world')" x-on:change="this.change($el)"/>...</button>
```

> It is important that if you have to add single or double quotes into the javascript, you replace them with any of the following symbols:

-  <code>`</code>
- `\\`
- `#` 

For example:

```html
<x-button
    :javascript="[
        'x-on:click' => 'console.log(`hello world`)',
        'x-on:click' => 'console.log(\\hello world\\)',
        'x-on:click' => 'console.log(#hello world#)',
    ]"
/>
```

## Groups 

It may be the case that you need to group several elements in a single container:

```html
<x-group 
    align="right" 
    width="w-1/3"
    position="horizontal"
>
    <x-button
        text="Cancel"
        type="button"
        color="danger"
        :javascript="[
            '@change' => 'this.change($el)',
        ]"
    />
    <x-button
        text="Submit"
        type="submit"
        color="success"
        conditional="auth()->user()->isAdmin()"
    />
</x-group>
```

### width 

Same as the other elements.

### align 

You can align the items inside the container using: `left`, `center` and `right`.

### position 

The element can be in `vertical` or in `horizontal`. The default value is `horizontal`.

## Roadmap

- Toggle/Boolean (alpinejs)
- Datetime (alpinejs, flatpickr) 
- Combobox (alpinejs)