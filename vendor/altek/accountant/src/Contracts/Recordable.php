<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Recordable extends Identifiable
{
    /**
     * Recordable Model ledgers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ledgers(): MorphMany;

    /**
     * Is recording enabled for this model?
     *
     * @return bool
     */
    public function isRecordingEnabled(): bool;

    /**
     * Determine whether an event is recordable.
     *
     * @param string $event
     *
     * @return bool
     */
    public function isEventRecordable(?string $event): bool;

    /**
     * Get the events that trigger a new Ledger record.
     *
     * @return array
     */
    public function getRecordableEvents(): array;

    /**
     * Get the Ledger threshold.
     *
     * @return int
     */
    public function getLedgerThreshold(): int;

    /**
     * Get the Ledger driver.
     *
     * @return string
     */
    public function getLedgerDriver(): ?string;

    /**
     * Collect the data for recording.
     *
     * @param string $event
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     *
     * @return array
     */
    public function collect(string $event): array;

    /**
     * Supply extra data for recording.
     *
     * @param string       $event
     * @param array        $properties
     * @param Identifiable $user
     *
     * @return array
     */
    public function supplyExtra(string $event, array $properties, ?Identifiable $user): array;

    /**
     * Get property ciphers.
     *
     * @return array
     */
    public function getCiphers(): array;

    /**
     * Check if the current state is reachable by retracing all the recorded steps.
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     *
     * @return bool
     */
    public function isCurrentStateReachable(): bool;
}
