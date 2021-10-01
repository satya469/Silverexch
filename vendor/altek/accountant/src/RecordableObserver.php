<?php

declare(strict_types=1);

namespace Altek\Accountant;

use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Facades\Accountant;

class RecordableObserver
{
    /**
     * Are we handling a restore event?
     *
     * @var bool
     */
    public static $restoring = false;

    /**
     * Are we handling a toggle event?
     *
     * @var bool
     */
    public static $toggling = false;

    /**
     * Are we handling a sync event?
     *
     * @var bool
     */
    public static $syncing = false;

    /**
     * Handle the retrieved event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return void
     */
    public function retrieved(Recordable $model): void
    {
        Accountant::record($model, 'retrieved');
    }

    /**
     * Handle the created event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return void
     */
    public function created(Recordable $model): void
    {
        Accountant::record($model, 'created');
    }

    /**
     * Handle the updated event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return void
     */
    public function updated(Recordable $model): void
    {
        // Ignore this event when restoring
        if (static::$restoring) {
            return;
        }

        Accountant::record($model, 'updated');
    }

    /**
     * Handle the restoring event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return void
     */
    public function restoring(Recordable $model): void
    {
        // This event triggers others that should be ignored, so we track
        // the original to avoid creating unnecessary Ledger records
        static::$restoring = true;
    }

    /**
     * Handle the restored event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return void
     */
    public function restored(Recordable $model): void
    {
        Accountant::record($model, 'restored');

        // Once the event terminates, the state is reverted
        static::$restoring = false;
    }

    /**
     * Handle the deleted event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return void
     */
    public function deleted(Recordable $model): void
    {
        Accountant::record($model, 'deleted');
    }

    /**
     * Handle the forceDeleted event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return void
     */
    public function forceDeleted(Recordable $model): void
    {
        Accountant::record($model, 'forceDeleted');
    }

    /**
     * Handle the toggling event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return void
     */
    public function toggling(Recordable $model): void
    {
        // This event triggers others that should be ignored, so we track
        // the original to avoid creating unnecessary Ledger records
        static::$toggling = true;
    }

    /**
     * Handle the toggled event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     * @param string                                 $relation
     * @param array                                  $attributes
     *
     * @return void
     */
    public function toggled(Recordable $model, string $relation, array $attributes): void
    {
        Accountant::record($model, 'toggled', $relation, $attributes);

        // Once the event terminates, the state is reverted
        static::$toggling = false;
    }

    /**
     * Handle the syncing event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     *
     * @return void
     */
    public function syncing(Recordable $model): void
    {
        // This event triggers others that should be ignored, so we track
        // the original to avoid creating unnecessary Ledger records
        static::$syncing = true;
    }

    /**
     * Handle the synced event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     * @param string                                 $relation
     * @param array                                  $attributes
     *
     * @return void
     */
    public function synced(Recordable $model, string $relation, array $attributes): void
    {
        Accountant::record($model, 'synced', $relation, $attributes);

        // Once the event terminates, the state is reverted
        static::$syncing = false;
    }

    /**
     * Handle the existingPivotUpdated event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     * @param string                                 $relation
     * @param array                                  $attributes
     *
     * @return void
     */
    public function existingPivotUpdated(Recordable $model, string $relation, array $attributes): void
    {
        // Ignore this event when syncing
        if (static::$syncing) {
            return;
        }

        Accountant::record($model, 'existingPivotUpdated', $relation, $attributes);
    }

    /**
     * Handle the attached event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     * @param string                                 $relation
     * @param array                                  $attributes
     *
     * @return void
     */
    public function attached(Recordable $model, string $relation, array $attributes): void
    {
        // Ignore this event when toggling or syncing
        if (static::$toggling || static::$syncing) {
            return;
        }

        Accountant::record($model, 'attached', $relation, $attributes);
    }

    /**
     * Handle the detached event.
     *
     * @param \Altek\Accountant\Contracts\Recordable $model
     * @param string                                 $relation
     * @param array                                  $attributes
     *
     * @return void
     */
    public function detached(Recordable $model, string $relation, array $attributes): void
    {
        // Ignore this event when toggling or syncing
        if (static::$toggling || static::$syncing) {
            return;
        }

        Accountant::record($model, 'detached', $relation, $attributes);
    }
}
