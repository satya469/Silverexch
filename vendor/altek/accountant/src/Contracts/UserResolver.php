<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface UserResolver
{
    /**
     * Resolve the User.
     *
     * @return Identifiable
     */
    public static function resolve(): ?Identifiable;
}
