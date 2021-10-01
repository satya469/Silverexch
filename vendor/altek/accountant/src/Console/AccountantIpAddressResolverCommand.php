<?php

declare(strict_types=1);

namespace Altek\Accountant\Console;

use Illuminate\Console\GeneratorCommand;

class AccountantIpAddressResolverCommand extends GeneratorCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'accountant:ip-address-resolver';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new IP Address resolver';

    /**
     * {@inheritdoc}
     */
    protected $type = 'IpAddressResolver';

    /**
     * {@inheritdoc}
     */
    protected function getStub(): string
    {
        return __DIR__.'/../../stubs/IpAddressResolver.stub';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Resolvers';
    }
}
