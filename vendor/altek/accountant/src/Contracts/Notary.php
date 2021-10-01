<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface Notary
{
    /**
     * Generate a signature based on the contents of an array.
     *
     * @param array $data
     *
     * @return string
     */
    public static function sign(array $data): string;

    /**
     * Validate an array against a signature.
     *
     * @param array  $data
     * @param string $signature
     *
     * @return bool
     */
    public static function validate(array $data, string $signature): bool;
}
