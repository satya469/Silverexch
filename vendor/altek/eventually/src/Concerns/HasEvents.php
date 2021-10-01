<?php

declare(strict_types=1);

namespace Altek\Eventually\Concerns;

trait HasEvents
{
    /**
     * Get the observable event names.
     *
     * @return array
     */
    public function getObservableEvents(): array
    {
        return \array_merge(parent::getObservableEvents(), [
            'toggling',
            'toggled',
            'syncing',
            'synced',
            'updatingExistingPivot',
            'existingPivotUpdated',
            'attaching',
            'attached',
            'detaching',
            'detached',
        ], $this->observables);
    }

    /**
     * Fire the given event for the pivot.
     *
     * @param string $event
     * @param bool   $halt
     * @param string $relation
     * @param array  $properties
     *
     * @return mixed
     */
    public function firePivotEvent($event, $halt = true, string $relation = null, array $properties = [])
    {
        if (! isset(static::$dispatcher)) {
            return true;
        }

        $method = $halt ? 'until' : 'dispatch';

        $result = $this->filterModelEventResults(
            $this->fireCustomModelEvent($event, $method)
        );

        if ($result === false) {
            return false;
        }

        return ! empty($result) ? $result : static::$dispatcher->{$method}("eloquent.{$event}: ".static::class, [
            $this,
            $relation,
            $properties,
        ]);
    }

    /**
     * Register a toggling model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function toggling($callback): void
    {
        static::registerModelEvent('toggling', $callback);
    }

    /**
     * Register a toggled model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function toggled($callback): void
    {
        static::registerModelEvent('toggled', $callback);
    }

    /**
     * Register a syncing model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function syncing($callback): void
    {
        static::registerModelEvent('syncing', $callback);
    }

    /**
     * Register a synced model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function synced($callback): void
    {
        static::registerModelEvent('synced', $callback);
    }

    /**
     * Register an updatingExistingPivot model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function updatingExistingPivot($callback): void
    {
        static::registerModelEvent('updatingExistingPivot', $callback);
    }

    /**
     * Register an existingPivotUpdated model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function existingPivotUpdated($callback): void
    {
        static::registerModelEvent('existingPivotUpdated', $callback);
    }

    /**
     * Register an attaching model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function attaching($callback): void
    {
        static::registerModelEvent('attaching', $callback);
    }

    /**
     * Register an attached model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function attached($callback): void
    {
        static::registerModelEvent('attached', $callback);
    }

    /**
     * Register a detaching model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function detaching($callback): void
    {
        static::registerModelEvent('detaching', $callback);
    }

    /**
     * Register a detached model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function detached($callback): void
    {
        static::registerModelEvent('detached', $callback);
    }
}
