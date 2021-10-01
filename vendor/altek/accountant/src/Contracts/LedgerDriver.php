<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface LedgerDriver
{
    /**
     * Create a Ledger from a Recordable model.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     * @param string                                 $event
     * @param string                                 $pivotRelation
     * @param array                                  $pivotProperties
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     *
     * @return \Altek\Accountant\Contracts\Ledger
     */
    public function record(
        Recordable $model,
        string $event,
        string $pivotRelation = null,
        array $pivotProperties = []
    ): Ledger;

    /**
     * Remove older ledgers that go over the threshold.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return bool
     */
    public function prune(Recordable $model): bool;
}
