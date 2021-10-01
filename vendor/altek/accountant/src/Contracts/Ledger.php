<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface Ledger
{
    /**
     * User accountable for the changes.
     *
     * @return mixed
     */
    public function user();

    /**
     * Recordable model to which this Ledger belongs to.
     *
     * @return mixed
     */
    public function recordable();

    /**
     * Compile data and metadata.
     *
     * @return array
     */
    public function compile(): array;

    /**
     * Get a property value.
     *
     * @param string $key
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     *
     * @return mixed
     */
    public function getProperty(string $key);

    /**
     * Get the Ledger data.
     *
     * @return array
     */
    public function getMetadata(): array;

    /**
     * Get the Recordable data.
     *
     * @param bool $all
     *
     * @return array
     */
    public function getData(bool $all = false): array;

    /**
     * Get the Pivot data.
     *
     * @return array
     */
    public function getPivotData(): array;

    /**
     * Extract a Recordable instance from the Ledger.
     *
     * @param bool $strict
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     * @throws \Altek\Accountant\Exceptions\DecipherException
     *
     * @return Recordable
     */
    public function extract(bool $strict = true): Recordable;

    /**
     * Check if the record is tainted.
     *
     * @return bool
     */
    public function isTainted(): bool;
}
