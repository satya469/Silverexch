<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface UserAgentResolver
{
    /**
     * Resolve the User Agent.
     *
     * @return string
     */
    public static function resolve(): ?string;
}
