<?php

declare(strict_types=1);

namespace Altek\Eventually\Relations\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection as BaseCollection;

trait InteractsWithPivotTable
{
    /**
     * Compile the available pivot properties.
     *
     * @param mixed $id
     * @param array $attributes
     *
     * @return array
     */
    protected function compilePivotProperties($id, array $attributes = []): array
    {
        $defaultProperties = [
            $this->foreignPivotKey => $this->parent->getAttribute($this->parentKey),
        ];

        if ($this instanceof MorphToMany) {
            $defaultProperties[$this->morphType] = $this->morphClass;
        }

        if ($id instanceof Model) {
            return [
                \array_merge($defaultProperties, $attributes, [
                    $this->relatedPivotKey => $id->getAttribute($this->relatedKey),
                ]),
            ];
        }

        if ($id instanceof Collection) {
            return $id->map(function (Model $model) use ($defaultProperties, $attributes) {
                return \array_merge($defaultProperties, $attributes, [
                    $this->relatedPivotKey => $model->getAttribute($this->relatedKey),
                ]);
            })->all();
        }

        if ($id instanceof BaseCollection) {
            $id = $id->all();
        }

        $properties = [];

        foreach ((array) $id as $key => $value) {
            if (\is_array($value)) {
                $properties[] = \array_merge($defaultProperties, $attributes, $value, [
                    $this->relatedPivotKey => $key,
                ]);
            } else {
                $properties[] = \array_merge($defaultProperties, $attributes, [
                    $this->relatedPivotKey => $value,
                ]);
            }
        }

        return $properties;
    }

    /**
     * Toggles a model (or models) from the parent.
     *
     * Each existing model is detached, and non existing ones are attached.
     *
     * @param mixed $ids
     * @param bool  $touch
     *
     * @return array|bool
     */
    public function toggle($ids, $touch = true)
    {
        $properties = $this->compilePivotProperties($ids);

        if ($this->parent->firePivotEvent('toggling', true, $this->getRelationName(), $properties) === false) {
            return false;
        }

        $changes = parent::toggle($ids, $touch);

        $this->parent->firePivotEvent('toggled', false, $this->getRelationName(), $properties);

        return $changes;
    }

    /**
     * Sync the intermediate tables with a list of IDs or collection of models.
     *
     * @param mixed $ids
     * @param bool  $detaching
     *
     * @return array|bool
     */
    public function sync($ids, $detaching = true)
    {
        $properties = $this->compilePivotProperties($ids);

        if ($this->parent->firePivotEvent('syncing', true, $this->getRelationName(), $properties) === false) {
            return false;
        }

        $changes = parent::sync($ids, $detaching);

        $this->parent->firePivotEvent('synced', false, $this->getRelationName(), $properties);

        return $changes;
    }

    /**
     * Update an existing pivot record on the table.
     *
     * @param mixed $id
     * @param array $attributes
     * @param bool  $touch
     *
     * @return int|bool
     */
    public function updateExistingPivot($id, array $attributes, $touch = true)
    {
        $properties = $this->compilePivotProperties($id, $attributes);

        if ($this->parent->firePivotEvent('updatingExistingPivot', true, $this->getRelationName(), $properties) === false) {
            return false;
        }

        $updated = parent::updateExistingPivot($id, $attributes, $touch);

        $this->parent->firePivotEvent('existingPivotUpdated', false, $this->getRelationName(), $properties);

        return $updated;
    }

    /**
     * Attach a model to the parent.
     *
     * @param mixed $id
     * @param array $attributes
     * @param bool  $touch
     *
     * @return bool
     */
    public function attach($id, array $attributes = [], $touch = true)
    {
        $properties = $this->compilePivotProperties($id, $attributes);

        if ($this->parent->firePivotEvent('attaching', true, $this->getRelationName(), $properties) === false) {
            return false;
        }

        parent::attach($id, $attributes, $touch);

        $this->parent->firePivotEvent('attached', false, $this->getRelationName(), $properties);

        return true;
    }

    /**
     * Detach models from the relationship.
     *
     * @param mixed $ids
     * @param bool  $touch
     *
     * @return int|bool
     */
    public function detach($ids = null, $touch = true)
    {
        // When the first argument is null, it means that all models will be detached from
        // the relationship, requiring the corresponding ids to be resolved for indexing
        $properties = $this->compilePivotProperties($ids ?? $this->query->pluck($this->query->qualifyColumn($this->relatedKey))->all());

        if ($this->parent->firePivotEvent('detaching', true, $this->getRelationName(), $properties) === false) {
            return false;
        }

        $results = parent::detach($ids, $touch);

        $this->parent->firePivotEvent('detached', false, $this->getRelationName(), $properties);

        return $results;
    }
}
