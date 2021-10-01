<?php

declare(strict_types=1);

namespace Altek\Accountant\Resolvers;

use Illuminate\Support\Facades\Request;

class IpAddressResolver implements \Altek\Accountant\Contracts\IpAddressResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve(): string
    {
        return Request::ip();
    }
}
