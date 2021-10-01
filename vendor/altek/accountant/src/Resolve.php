<?php

declare(strict_types=1);

namespace Altek\Accountant;

use Altek\Accountant\Contracts\ContextResolver;
use Altek\Accountant\Contracts\Identifiable;
use Altek\Accountant\Contracts\IpAddressResolver;
use Altek\Accountant\Contracts\UrlResolver;
use Altek\Accountant\Contracts\UserAgentResolver;
use Altek\Accountant\Contracts\UserResolver;
use Altek\Accountant\Exceptions\AccountantException;
use Illuminate\Support\Facades\Config;

class Resolve
{
    /**
     * Resolve the Context.
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     *
     * @return int
     */
    public static function context(): int
    {
        $implementation = Config::get('accountant.resolvers.context');

        if (! \is_subclass_of($implementation, ContextResolver::class)) {
            throw new AccountantException(\sprintf('Invalid ContextResolver implementation: "%s"', $implementation));
        }

        return \call_user_func([$implementation, 'resolve']);
    }

    /**
     * Resolve the IP Address.
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     *
     * @return string
     */
    public static function ipAddress(): string
    {
        $implementation = Config::get('accountant.resolvers.ip_address');

        if (! \is_subclass_of($implementation, IpAddressResolver::class)) {
            throw new AccountantException(\sprintf('Invalid IpAddressResolver implementation: "%s"', $implementation));
        }

        return \call_user_func([$implementation, 'resolve']);
    }

    /**
     * Resolve the URL.
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     *
     * @return string
     */
    public static function url(): string
    {
        $implementation = Config::get('accountant.resolvers.url');

        if (! \is_subclass_of($implementation, UrlResolver::class)) {
            throw new AccountantException(\sprintf('Invalid UrlResolver implementation: "%s"', $implementation));
        }

        return \call_user_func([$implementation, 'resolve']);
    }

    /**
     * Resolve the User Agent.
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     *
     * @return string
     */
    public static function userAgent(): ?string
    {
        $implementation = Config::get('accountant.resolvers.user_agent');

        if (! \is_subclass_of($implementation, UserAgentResolver::class)) {
            throw new AccountantException(\sprintf('Invalid UserAgentResolver implementation: "%s"', $implementation));
        }

        return \call_user_func([$implementation, 'resolve']);
    }

    /**
     * Resolve the User.
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     *
     * @return Identifiable
     */
    public static function user(): ?Identifiable
    {
        $implementation = Config::get('accountant.resolvers.user');

        if (! \is_subclass_of($implementation, UserResolver::class)) {
            throw new AccountantException(\sprintf('Invalid UserResolver implementation: "%s"', $implementation));
        }

        return \call_user_func([$implementation, 'resolve']);
    }
}
