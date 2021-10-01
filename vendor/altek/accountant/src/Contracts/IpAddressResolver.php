<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface IpAddressResolver
{
    /**
     * Resolve the IP Address.
     *
     * @return string
     */
    public static function resolve(): string;
}
