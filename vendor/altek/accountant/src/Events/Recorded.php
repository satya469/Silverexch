<?php

declare(strict_types=1);

namespace Altek\Accountant\Events;

use Altek\Accountant\Contracts\Ledger;
use Altek\Accountant\Contracts\LedgerDriver;
use Altek\Accountant\Contracts\Recordable;

class Recorded
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
     * The Ledger model.
     *
     * @var \Altek\Accountant\Contracts\Ledger
     */
    public $ledger;

    /**
     * Create a new Recorded event instance.
     *
     * @param \Altek\Accountant\Contracts\Recordable   $model
     * @param \Altek\Accountant\Contracts\LedgerDriver $driver
     * @param \Altek\Accountant\Contracts\Ledger       $ledger
     */
    public function __construct(Recordable $model, LedgerDriver $driver, ?Ledger $ledger)
    {
        $this->model  = $model;
        $this->driver = $driver;
        $this->ledger = $ledger;
    }
}
