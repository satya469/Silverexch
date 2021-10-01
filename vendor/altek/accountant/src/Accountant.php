<?php

declare(strict_types=1);

namespace Altek\Accountant;

use Altek\Accountant\Contracts\LedgerDriver;
use Altek\Accountant\Drivers\Database;
use Altek\Accountant\Events\Recorded;
use Altek\Accountant\Events\Recording;
use Altek\Accountant\Exceptions\AccountantException;
use Illuminate\Support\Manager;

class Accountant extends Manager implements Contracts\Accountant
{
    /**
     * {@inheritdoc}
     */
    public function getDefaultDriver(): string
    {
        return 'database';
    }

    /**
     * Create an instance of the Ledger database driver.
     *
     * @return \Altek\Accountant\Drivers\Database
     */
    protected function createDatabaseDriver(): Database
    {
        return $this->app->make(Database::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function createDriver($driver)
    {
        if (\class_exists($driver)) {
            return $this->app->make($driver);
        }

        return parent::createDriver($driver);
    }

    /**
     * {@inheritdoc}
     */
    public function ledgerDriver(Contracts\Recordable $model): LedgerDriver
    {
        $driver = $this->driver($model->getLedgerDriver());

        if ($driver instanceof LedgerDriver) {
            return $driver;
        }

        throw new AccountantException('The LedgerDriver contract must be implemented by the driver');
    }

    /**
     * {@inheritdoc}
     */
    public function record(
        Contracts\Recordable $model,
        string $event,
        string $pivotRelation = null,
        array $pivotProperties = []
    ): void {
        if (! $model->isRecordingEnabled() || ! $model->isEventRecordable($event)) {
            return;
        }

        $driver = $this->ledgerDriver($model);

        if ($this->app->make('events')->until(new Recording($model, $driver, $pivotRelation, $pivotProperties)) === false) {
            return;
        }

        if ($ledger = $driver->record($model, $event, $pivotRelation, $pivotProperties)) {
            $driver->prune($model);
        }

        $this->app->make('events')->dispatch(new Recorded($model, $driver, $ledger));
    }
}
