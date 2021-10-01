<?php

declare(strict_types=1);

namespace Altek\Accountant\Ciphers;

use Altek\Accountant\Exceptions\DecipherException;

class Bleach implements \Altek\Accountant\Contracts\Cipher
{
    /**
     * {@inheritdoc}
     */
    public static function isOneWay(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function cipher($value)
    {
        $length = \mb_strlen($value);
        $tenth  = (int) \ceil($length / 10);

        // Make sure single character strings get redacted
        $start = (int) ($length > $tenth) ? ($length - $tenth) : 1;

        return \str_pad(\mb_substr($value, $start), $length, '-', STR_PAD_LEFT);
    }

    /**
     * {@inheritdoc}
     */
    public static function decipher($value): void
    {
        throw new DecipherException('Value deciphering is not supported by this implementation', $value);
    }
}
