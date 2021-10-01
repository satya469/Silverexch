<?php

declare(strict_types=1);

namespace Altek\Accountant\Resolvers;

use Illuminate\Support\Facades\Request;

class UserAgentResolver implements \Altek\Accountant\Contracts\UserAgentResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve(): ?string
    {
        return Request::header('User-Agent');
    }
}
