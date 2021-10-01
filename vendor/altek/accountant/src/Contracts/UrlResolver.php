<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface UrlResolver
{
    /**
     * Resolve the URL.
     *
     * @return string
     */
    public static function resolve(): string;
}
