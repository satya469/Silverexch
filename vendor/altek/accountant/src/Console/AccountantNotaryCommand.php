<?php

declare(strict_types=1);

namespace Altek\Accountant\Console;

use Illuminate\Console\GeneratorCommand;

class AccountantNotaryCommand extends GeneratorCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'accountant:notary';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new Notary implementation';

    /**
     * {@inheritdoc}
     */
    protected $type = 'Notary';

    /**
     * {@inheritdoc}
     */
    protected function getStub(): string
    {
        return __DIR__.'/../../stubs/Notary.stub';
    }
}
