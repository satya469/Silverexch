<?php

declare(strict_types=1);

namespace Altek\Accountant\Resolvers;

use Altek\Accountant\Contracts\Identifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserResolver implements \Altek\Accountant\Contracts\UserResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve(): ?Identifiable
    {
        foreach (Config::get('accountant.user.guards') as $guard) {
            if ($user = Auth::guard($guard)->user()) {
                return $user;
            }
        }

        return null;
    }
}
