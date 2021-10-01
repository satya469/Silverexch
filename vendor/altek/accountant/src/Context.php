<?php

declare(strict_types=1);

namespace Altek\Accountant;

use Illuminate\Support\Facades\Config;

class Context
{
    /**
     * Testing context (PHPUnit).
     */
    public const TEST = 0b001;

    /**
     * Command Line Interface context (Migrations, Jobs, Commands, Tinker, ...).
     */
    public const CLI = 0b010;

    /**
     * Web context (Apache, CGI, FPM, ...).
     */
    public const WEB = 0b100;

    /**
     * Determine if a given context is valid.
     *
     * @param int $context
     *
     * @return bool
     */
    public static function isValid(int $context): bool
    {
        return (Config::get('accountant.contexts') & $context) !== 0b000;
    }
}
