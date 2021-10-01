<?php

declare(strict_types=1);

namespace Altek\Accountant;

use Altek\Accountant\Contracts\Cipher;
use Altek\Accountant\Contracts\Identifiable;
use Altek\Accountant\Contracts\Notary;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Exceptions\AccountantException;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

trait Ledger
{
    /**
     * Ledger data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Metadata attributes.
     *
     * @var array
     */
    protected $metadata = [];

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        $userPrefix = Config::get('accountant.user.prefix');

        $relation = $this->morphTo($userPrefix, $userPrefix.'_type', $userPrefix.'_id');

        return $this->resolveTrashedRelation($relation);
    }

    /**
     * {@inheritdoc}
     */
    public function recordable()
    {
        return $this->resolveTrashedRelation($this->morphTo());
    }

    /**
     * Trashed relation resolver.
     *
     * @param MorphTo $relation
     *
     * @return MorphTo
     */
    protected function resolveTrashedRelation(MorphTo $relation): MorphTo
    {
        $traits = class_uses_recursive($relation->getRelated());

        if (\in_array(SoftDeletes::class, $traits, true)) {
            return $relation->withTrashed();
        }

        return $relation;
    }

    /**
     * Get a new Recordable instance.
     *
     * @return \Altek\Accountant\Contracts\Recordable
     */
    protected function getRecordableInstance(): Recordable
    {
        return $this->recordable()->getRelated();
    }

    /**
     * {@inheritdoc}
     */
    public function compile(): array
    {
        $userPrefix = Config::get('accountant.user.prefix');

        // Metadata
        $this->data = [
            'ledger_id'                  => $this->getKey(),
            'ledger_context'             => (int) $this->getAttributeFromArray('context'),
            'ledger_event'               => $this->getAttributeFromArray('event'),
            'ledger_url'                 => $this->getAttributeFromArray('url'),
            'ledger_ip_address'          => $this->getAttributeFromArray('ip_address'),
            'ledger_user_agent'          => $this->getAttributeFromArray('user_agent'),
            'ledger_'.static::CREATED_AT => $this->serializeDate($this->getAttributeValue(static::CREATED_AT)),
            'ledger_'.static::UPDATED_AT => $this->serializeDate($this->getAttributeValue(static::UPDATED_AT)),
            'ledger_signature'           => $this->getAttributeFromArray('signature'),
            $userPrefix.'_id'            => $this->getAttributeFromArray($userPrefix.'_id'),
            $userPrefix.'_type'          => $this->getAttributeFromArray($userPrefix.'_type'),
        ];

        if ($this->user instanceof Identifiable) {
            foreach ($this->user->getArrayableAttributes() as $attribute => $value) {
                $this->data[$userPrefix.'_'.$attribute] = $value;
            }
        }

        $this->metadata = \array_keys($this->data);

        // Recordable data
        foreach ($this->getDecipheredProperties(false) as $key => $value) {
            $this->data['recordable_'.$key] = $value;
        }

        return $this->data;
    }

    /**
     * Get the formatted property of a model.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    protected function getFormattedProperty(Model $model, string $key, $value)
    {
        // Apply defined get mutator
        if ($model->hasGetMutator($key)) {
            return $model->mutateAttribute($key, $value);
        }

        // Cast to a native PHP type or to a custom cast (as of Laravel 7.x)
        if ($model->hasCast($key)) {
            return $model->castAttribute($key, $value);
        }

        // Honour DateTime attribute
        if ($value !== null && \in_array($key, $model->getDates(), true)) {
            return $model->asDateTime($value);
        }

        return $value;
    }

    /**
     * Get Recordable properties (deciphered).
     *
     * @param bool $strict
     *
     * @throws \Altek\Accountant\Exceptions\AccountantException
     * @throws \Altek\Accountant\Exceptions\DecipherException
     *
     * @return array
     */
    protected function getDecipheredProperties(bool $strict = true): array
    {
        $properties = $this->getAttributeValue('properties');

        foreach ($this->getRecordableInstance()->getCiphers() as $key => $implementation) {
            if (! \array_key_exists($key, $properties)) {
                throw new AccountantException(\sprintf('Invalid property: "%s"', $key));
            }

            if (! \is_subclass_of($implementation, Cipher::class)) {
                throw new AccountantException(\sprintf('Invalid Cipher implementation: "%s"', $implementation));
            }

            // If strict mode is on, an exception is thrown when there's an attempt to decipher
            // one way ciphered data, otherwise we just skip to the next property value
            if (\call_user_func([$implementation, 'isOneWay']) && ! $strict) {
                continue;
            }

            $properties[$key] = \call_user_func([$implementation, 'decipher'], $properties[$key]);
        }

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperty(string $key)
    {
        if (! \array_key_exists($key, $this->data)) {
            throw new AccountantException(\sprintf('Invalid property: "%s"', $key));
        }

        $value = $this->data[$key];

        // User property
        $userPrefix = Config::get('accountant.user.prefix');

        if ($this->user && Str::startsWith($key, $userPrefix.'_')) {
            $userPrefixOffset = \mb_strlen($userPrefix.'_');

            return $this->getFormattedProperty($this->user, \mb_substr($key, $userPrefixOffset), $value);
        }

        // Recordable property
        if (Str::startsWith($key, 'recordable_')) {
            return $this->getFormattedProperty($this->getRecordableInstance(), \mb_substr($key, 11), $value);
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata(): array
    {
        if (empty($this->data)) {
            $this->compile();
        }

        $metadata = [];

        foreach ($this->metadata as $key) {
            $value = $this->getProperty($key);

            $metadata[$key] = $value instanceof DateTimeInterface
                ? $this->serializeDate($value)
                : $value;
        }

        return $metadata;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(bool $all = false): array
    {
        if (empty($this->data)) {
            $this->compile();
        }

        $data = [];

        $properties = $all ? \array_keys($this->getAttributeValue('properties')) : $this->getAttributeValue('modified');

        foreach ($properties as $key) {
            $value = $this->getProperty(\sprintf('recordable_%s', $key));

            $data[$key] = $value instanceof DateTimeInterface
                ? $this->serializeDate($value)
                : $value;
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getPivotData(): array
    {
        return $this->pivot;
    }

    /**
     * {@inheritdoc}
     */
    public function extract(bool $strict = true): Recordable
    {
        if ($strict && $this->isTainted()) {
            throw new AccountantException('Extraction failed due to tainted data');
        }

        return $this->getRecordableInstance()->newFromBuilder($this->getDecipheredProperties($strict));
    }

    /**
     * {@inheritdoc}
     */
    public function isTainted(): bool
    {
        if (! $this->usesTimestamps()) {
            throw new AccountantException('The use of timestamps is required');
        }

        $notary = Config::get('accountant.notary');

        if (! \is_subclass_of($notary, Notary::class)) {
            throw new AccountantException(\sprintf('Invalid Notary implementation: "%s"', $notary));
        }

        // A date mismatch is enough for a record to be considered tainted
        $createdAt = $this->getAttributeValue(static::CREATED_AT);
        $updatedAt = $this->getAttributeValue(static::UPDATED_AT);

        if ($createdAt->notEqualTo($updatedAt)) {
            return true;
        }

        $properties = $this->attributesToArray();

        // Exclude properties that were not present when the signing took place
        unset($properties[$this->getKeyName()], $properties['signature']);

        return \call_user_func([$notary, 'validate'], $properties, $this->getAttributeFromArray('signature')) === false;
    }
}
