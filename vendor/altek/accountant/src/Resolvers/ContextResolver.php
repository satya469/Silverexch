<?php

declare(strict_types=1);

namespace Altek\Accountant\Resolvers;

use Altek\Accountant\Context;
use Illuminate\Support\Facades\App;

class ContextResolver implements \Altek\Accountant\Contracts\ContextResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve(): int
    {
        if (App::runningUnitTests()) {
            return Context::TEST;
        }

        if (App::runningInConsole()) {
            return Context::CLI;
        }

        return Context::WEB;
    }
}
