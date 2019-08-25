<?php

use Symfony\Component\Translation\Translator;

/**
 * Text translation.
 *
 * @param string|Translator $message The message or the translator instance
 *
 * @return string The translated message
 *
 * <code>
 * echo __('Hello');
 * echo __('There are %s users logged in.', 7);
 * </code>
 */
function __($message): string
{
    /** @var Translator $translator */
    static $translator = null;
    if ($message instanceof Translator) {
        $translator = $message;

        return '';
    }

    $translated = $translator->trans($message);
    $context = array_slice(func_get_args(), 1);
    if (!empty($context)) {
        $translated = vsprintf($translated, $context);
    }

    return $translated;
}
