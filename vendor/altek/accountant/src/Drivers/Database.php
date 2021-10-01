<?php

declare(strict_types=1);

namespace Altek\Accountant\Drivers;

use Altek\Accountant\Contracts\Ledger;
use Altek\Accountant\Contracts\LedgerDriver;
use Altek\Accountant\Contracts\Notary;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Exceptions\AccountantException;
use Illuminate\Support\Facades\Config;

class Database implements LedgerDriver
{
    /**
     * {@inheritdoc}
     */
    public function record(
        Recordable $model,
        string $event,
        string $pivotRelation = null,
        array $pivotProperties = []
    ): Ledger {
        $notary = Config::get('accountant.notary');

        if (! \is_subclass_of($notary, Notary::class)) {
            throw new AccountantException(\sprintf('Invalid Notary implementation: "%s"', $notary));
        }

        $implementation = Config::get('accountant.ledger.implementation');

        if (! \is_subclass_of($implementation, Ledger::class)) {
            throw new AccountantException(\sprintf('Invalid Ledger implementation: "%s"', $implementation));
        }

        $ledger = new $implementation();

        // Set the Ledger properties
        foreach ($model->collect($event) as $property => $value) {
            $ledger->setAttribute($property, $value);
        }

        if ($ledger->usesTimestamps()) {
            $ledger->setCreatedAt($ledger->freshTimestamp())
                ->setUpdatedAt($ledger->freshTimestamp());
        }

        $ledger->setAttribute('pivot', $pivotRelation ? [
            'relation'   => $pivotRelation,
            'properties' => $pivotProperties,
        ] : []);

        // Sign and store the record
        $ledger->setAttribute('signature', \call_user_func([$notary, 'sign'], $ledger->attributesToArray()))
            ->save();

        return $ledger;
    }

    /**
     * {@inheritdoc}
     */
    public function prune(Recordable $model): bool
    {
        if (($threshold = $model->getLedgerThreshold()) > 0) {
            $forRemoval = $model->ledgers()
                ->latest()
                ->get()
                ->slice($threshold)
                ->pluck('id');

            if (! $forRemoval->isEmpty()) {
                return $model->ledgers()
                    ->whereIn('id', $forRemoval)
                    ->delete() > 0;
            }
        }

        return false;
    }
}
