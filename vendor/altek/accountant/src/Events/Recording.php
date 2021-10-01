<?php

declare(strict_types=1);

namespace Altek\Accountant\Events;

use Altek\Accountant\Contracts\LedgerDriver;
use Altek\Accountant\Contracts\Recordable;

class Recording
{
    /**
     * The Recordable model.
     *
     * @var \Altek\Accountant\Contracts\Recordable
     */
    public $model;

    /**
     * Ledger driver.
     *
     * @var \Altek\Accountant\Contracts\LedgerDriver
     */
    public $driver;

    /**
     * Pivot relation name.
     *
     * @var string
     */
    public $pivotRelation;

    /**
     * Pivot properties.
     *
     * @var array
     */
    public $pivotProperties;

    /**
     * Create a new Recording event instance.
     *
     * @param \Altek\Accountant\Contracts\Recordable   $model
     * @param \Altek\Accountant\Contracts\LedgerDriver $driver
     * @param string                                   $pivotRelation
     * @param array                                    $pivotProperties
     */
    public function __construct(Recordable $model, LedgerDriver $driver, string $pivotRelation = null, array $pivotProperties = [])
    {
        $this->model           = $model;
        $this->driver          = $driver;
        $this->pivotRelation   = $pivotRelation;
        $this->pivotProperties = $pivotProperties;
    }
}
