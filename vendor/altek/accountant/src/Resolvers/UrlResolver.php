<?php

declare(strict_types=1);

namespace Altek\Accountant\Resolvers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class UrlResolver implements \Altek\Accountant\Contracts\UrlResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve(): string
    {
        if (App::runningInConsole()) {
            return 'Command Line Interface';
        }

        return Request::fullUrl();
    }
}
