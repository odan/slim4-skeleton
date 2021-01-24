---
layout: default
title: Translations
published: false
nav_order: 11
---

# Translations

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

### Translating messages

### Requirements

* [Poedit](https://poedit.net/) (Translation editor)

### Usage

* Start Poedit and open the po-file from `resources/translations/`
* Click `Update from source`
* Translate the text and save the file

### Creating a new PO file

* Copy an existing po file from `resources/translations/` and rename it, e.g. `it_IT_messages.po`
* Start Poedit and open the po-file from `resources/translations/`
* Open the menu: `Catalogue > Properties...` and change the language.
* Save the file

## Translations in PHP

You can translate messages using the global `__()` helper function. 

```php
echo __('I love programming.');
```

To translate a message with a placeholder use the [sprintf](https://www.php.net/manual/en/function.sprintf.php) syntax:

```php
echo __('There are %s users logged in.', 7);
```

### Determining The Current Locale

You can use the UserAuth instance to get the user's locale.

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

## Translations in Templates

You can use the `trans` filter to translate messages in Twig templates.

Translating a message:

{% raw %}
```twig
{{ 'Yes'|trans }}
```
{% endraw %}

Translating a message with a placeholder:

{% raw %}
```twig
{{ 'Hello, %s%'|trans({'%s%': username}) }}
```
{% endraw %}

Read more: 

* <https://twig-extensions.readthedocs.io/en/latest/i18n.html#usage>
* <https://symfony.com/doc/current/reference/twig_reference.html#trans>

### Updating Translation Strings

To compile all Twig files to PHP, run:

```
composer twig:compile
```

Then open PoEdit and update the PO file from source to fetch
and translate the generated messages.


