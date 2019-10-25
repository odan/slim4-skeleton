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

Translation files are stored in the directory: `resources/locale` 

Within this directory there should be a `mo` and `po` file for each language supported by the application.

The source language is always english. You don't need a translation file for english.

Example:

* de_DE_messages.mo
* de_DE_messages.po
* fr_FR_messages.mo
* fr_FR_messages.po

### Configure Translation

*This section is under construction!*

* todo: Add description how to add more languages

### Determining The Current Locale

You may use the getLocale and isLocale methods on the App facade to determine 
the current locale or check if the locale is a given value:

```php
$locale = $this->locale->getLocale(); // en_US
```

### Defining Translation Strings

*This section is under construction!*

To parse all translation strings run:

```bash
$ composer compile-twig
```

This command will scan your twig templates, javascripts and PHP classes for the `__()` 
function call and stores all text entries into po-files. 

You can find all-po files in the: `resources/locale` directory. 

[PoEdit](https://poedit.net/) is the recommended PO-file editor for the generated po-files.
 

### Retrieving Translation Strings

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

## Assets

### Updating Assets

To update all main assets like jquery and bootstrap run:

```bash
$ composer update-assets
```

You can add more assets in `package.json` or directly via `npm`.

## Compiling Assets

To compile all assets, run:

```
npx webpack
```

To compile and minify all assets, run:

```
npx webpack --mode=production
```

To start frontend tests, run:

```
npm run test
```

To start frontend tests with code coverage, run:

```
npm run test:coverage
```
