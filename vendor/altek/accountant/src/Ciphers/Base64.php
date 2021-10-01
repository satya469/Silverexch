<?php

declare(strict_types=1);

namespace Altek\Accountant\Ciphers;

class Base64 implements \Altek\Accountant\Contracts\Cipher
{
    /**
     * {@inheritdoc}
     */
    public static function isOneWay(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function cipher($value)
    {
        return \base64_encode((string) $value);
    }

    /**
     * {@inheritdoc}
     */
    public static function decipher($value)
    {
        return \base64_decode($value, true);
    }
}
