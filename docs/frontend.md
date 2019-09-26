## Frontend

### Twig Templates

Twig is the simple, yet powerful templating engine provided by Symfony. 

In fact, all Twig views are compiled into plain PHP code and 
cached until they are modified, meaning Twig adds essentially 
zero overhead to your application. 

Twig view files use the `.twig` file extension and are typically stored in the `templates/` directory.

### Translation

The integrated localization features provide a convenient way to retrieve strings 
in various languages, allowing you to easily support multiple languages within 
your application. 

Language strings are stored in files within the `resources/locale` directory. 

Within this directory there should be a `mo` and `po` file for each language supported by the application.

The source language is always english. You don't need a translation file for english.

Example:

* de_DE_messages.mo
* de_DE_messages.po
* fr_FR_messages.mo
* fr_FR_messages.po

#### Configure Translation

* todo: Add description how to add more languages

#### Determining The Current Locale

You may use the getLocale and isLocale methods on the App facade to determine 
the current locale or check if the locale is a given value:

```php
$locale = $this->locale->getLocale(); // en_US
```

#### Defining Translation Strings

To parse all translation strings run:

```bash
$ ant parse-text
```

This command will scan your twig templates, javascripts and PHP classes for the `__()` 
function call and stores all text entries into po-files. 

You can find all-po files in the: `resources/locale` directory. 

[PoEdit](https://poedit.net/) is the recommended PO-file editor for the generated po-files.
 

#### Retrieving Translation Strings

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

[Read more](https://github.com/odan/twig-translation#usage)

### Assets

#### Updating Assets

To update all main assets like jquery and bootstrap run:

```bash
$ ant update-assets
```

You can add more assets in `package.json` or directly via `npm`.

Open the file `build.xml` and navigate to the target `update-assets` 
and add more items to copy the required files into the `public/` directory.


<hr>

Navigation: [Index](readme.md)