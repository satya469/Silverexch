<?php

declare(strict_types=1);

namespace Altek\Accountant\Console;

use Illuminate\Console\GeneratorCommand;

class AccountantLedgerDriverCommand extends GeneratorCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'accountant:ledger-driver';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new Ledger driver';

    /**
     * {@inheritdoc}
     */
    protected $type = 'LedgerDriver';

    /**
     * {@inheritdoc}
     */
    protected function getStub(): string
    {
        return __DIR__.'/../../stubs/LedgerDriver.stub';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\LedgerDrivers';
    }
}
