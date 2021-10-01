<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface Cipher
{
    /**
     * Is this a one way cipher implementation?
     *
     * @return bool
     */
    public static function isOneWay(): bool;

    /**
     * Cipher a property value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public static function cipher($value);

    /**
     * Decipher a property value.
     *
     * @param mixed $value
     *
     * @throws \Altek\Accountant\Exceptions\DecipherException
     *
     * @return mixed
     */
    public static function decipher($value);
}
