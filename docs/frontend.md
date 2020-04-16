---
layout: default
title: Frontend
nav_order: 11
---

# Frontend

## Twig Templates

Twig is the simple, yet powerful templating engine provided by Symfony. 

All Twig templates with the extension `*.twig` are stored in the directory: `templates/`

Twig templates will be converted to native PHP code and cached until the template changes. 
This means that Twig does not add much overhead to your application.

## Translation

The integrated localization features provides a convenient way to retrieve strings 
in various languages, allowing you to easily support multiple languages within 
your application. 

The directory for all `*.mo` and `*.po` translation files is: `resources/translations/`

The source language is always english. You don't need a translation file for english.

Example:

* de_DE_messages.mo
* de_DE_messages.po
* fr_FR_messages.mo
* fr_FR_messages.po

## Updating Translation Strings

### Requirements

* [Poedit](https://poedit.net/) (A translations editor)

### Setting up a PO file

* Copy an existing po file from `resources/translations/` and rename it, e.g. `it_IT_messages.po`
* Start Poedit and open the po-file from `resources/translations/`
* Open the menu: `Catalogue > Properties...` and change the language.
* Save the file

### Usage

* Start Poedit and open the po-file from `resources/translations/`
* Click `Update from source`
* Translate the text and save the file

## Retrieving Translation Strings

You may retrieve lines from language files using the `__` php helper function. 

The `__` method accepts the text of the translation string as its first argument. 

```php
echo __('I love programming.');
```

Translate a text with a placeholder in PHP:

```php
echo __('There are %s users logged in.', 7);
```

Of course if you are using the **Twig** templating engine, you may use 
the `__` helper function to echo the translation string.

Translate a text:

{% raw %}
```twig
{{ __('Yes') }}
```
{% endraw %}

Translate a text with a placeholder:

{% raw %}
```twig
{{ __('Hello: %s', username) }}
```
{% endraw %}

Read more: [Twig translation usage](https://github.com/odan/twig-translation#usage)

## Determining The Current Locale

You can use the UserAuth instance to get the users locale.

```php

use App\Domain\User\Service\UserAuth;
// ...

public function __construct(UserAuth $auth)
{
    $this->auth = $auth;
}

//...

$locale = $this->auth->getUser()->locale; // en_US
```

## Assets

### Updating packages

To update all packages like jQuery and Bootstrap run:

```bash
npm update
```

### Installing packages

To install a public package, on the command line, run:

```bash
npm install <package_name>
```

### Compiling Assets

To compile all assets for development, run:

```
npm run build:dev
```

To compile and minify all assets for production, run:

```
npm run build
```

To watch files and recompile whenever they change, run:

```
npm run watch
```

### Testing

To start frontend tests, run:

```
npm run test
```

To start frontend tests with code coverage, run:

```
npm run test:coverage
```
