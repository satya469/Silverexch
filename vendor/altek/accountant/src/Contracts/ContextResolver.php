<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface ContextResolver
{
    /**
     * Resolve the current context.
     *
     * @return int
     */
    public static function resolve(): int;
}
