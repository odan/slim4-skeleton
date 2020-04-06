<?php

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Translate text.
 *
 * @param string|TranslatorInterface $message The message being translated or the translator
 * @param string|int|float|bool ...$context The context arguments
 *
 * @return string The translated message
 */
function __($message, ...$context): string
{
    /** @var TranslatorInterface $translator */
    static $translator = null;
    if ($message instanceof TranslatorInterface) {
        $translator = $message;

        return '';
    }

    $translated = $translator->trans($message);
    if (!empty($context)) {
        $translated = vsprintf($translated, $context);
    }

    return $translated;
}
