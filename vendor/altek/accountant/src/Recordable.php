<?php

declare(strict_types=1);

namespace Altek\Accountant;

use Altek\Accountant\Contracts\Cipher;
use Altek\Accountant\Contracts\Identifiable;
use Altek\Accountant\Exceptions\AccountantException;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Config;

trait Recordable
{
    /**
     * Is recording enabled?
     *
     * @var bool
     */
    public static $recordingEnabled = true;

    /**
     * Determine if the observer should be registered.
     *
     * @throws AccountantException
     *
     * @return bool
     */
    public static function shouldRegisterObserver(): bool
    {
        if (! static::$recordingEnabled) {
            return false;
        }

        return Context::isValid(Resolve::context());
    }

    /**
     * Recordable boot logic.
     *
     * @throws AccountantException
     *
     * @return void
     */
    public static function bootRecordable(): void
    {
        if (static::shouldRegisterObserver()) {
            static::observe(new RecordableObserver());
        }
    }

    /**
     * Disable Recording.
     *
     * @return void
     */
    public static function disableRecording(): void
    {
        static::$recordingEnabled = false;
    }

    /**
     * Enable Recording.
     *
     * @return void
     */
    public static function enableRecording(): void
    {
        static::$recordingEnabled = true;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->getKey();
    }

    /**
     * {@inheritdoc}
     */
    public function ledgers(): MorphMany
    {
        return $this->morphMany(Config::get('accountant.ledger.implementation'), 'recordable');
    }

    /**
     * {@inheritdoc}
     */
    public function isRecordingEnabled(): bool
    {
        return static::$recordingEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function isEventRecordable(?string $event): bool
    {
        return \in_array($event, $this->getRecordableEvents(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function getRecordableEvents(): array
    {
        return $this->recordableEvents ?? Config::get('accountant.events');
    }

    /**
     * {@inheritdoc}
     */
    public function getLedgerThreshold(): int
    {
        return $this->ledgerThreshold ?? Config::get('accountant.ledger.threshold');
    }

    /**
     * {@inheritdoc}
     */
    public function getLedgerDriver(): ?string
    {
        return $this->ledgerDriver ?? Config::get('accountant.ledger.driver');
    }

    /**
     * {@inheritdoc}
     */
    public function collect(string $event): array
    {
        if (! $this->isRecordingEnabled()) {
            throw new AccountantException('Recording is not enabled');
        }

        if (! $this->isEventRecordable($event)) {
            throw new AccountantException(\sprintf('Invalid event: "%s"', $event));
        }

        $properties = $this->getAttributes();

        // Cipher property values
        foreach ($this->getCiphers() as $property => $implementation) {
            if (! \array_key_exists($property, $properties)) {
                throw new AccountantException(\sprintf('Invalid property: "%s"', $property));
            }

            if (! \is_subclass_of($implementation, Cipher::class)) {
                throw new AccountantException(\sprintf('Invalid Cipher implementation: "%s"', $implementation));
            }

            $properties[$property] = \call_user_func([$implementation, 'cipher'], $properties[$property]);
        }

        $user = Resolve::user();

        $userPrefix = Config::get('accountant.user.prefix');

        return [
            $userPrefix.'_id'   => $user ? $user->getIdentifier() : null,
            $userPrefix.'_type' => $user ? $user->getMorphClass() : null,
            'context'           => Resolve::context(),
            'event'             => $event,
            'recordable_id'     => $this->getIdentifier(),
            'recordable_type'   => $this->getMorphClass(),
            'properties'        => $properties,
            'modified'          => \array_keys($this->getDirty()),
            'extra'             => $this->supplyExtra($event, $properties, $user),
            'url'               => Resolve::url(),
            'ip_address'        => Resolve::ipAddress(),
            'user_agent'        => Resolve::userAgent(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supplyExtra(string $event, array $properties, ?Identifiable $user): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getCiphers(): array
    {
        return $this->ciphers ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function isCurrentStateReachable(): bool
    {
        if (! $this->usesTimestamps()) {
            throw new AccountantException('The use of timestamps is required');
        }

        $ledgers = $this->ledgers()->oldest()->get();

        // Unavailable Ledger history
        if ($ledgers->isEmpty()) {
            return false;
        }

        // The first Ledger must be for the created event
        if ($ledgers->first()->event !== 'created') {
            return false;
        }

        // The created at value must match
        $createdAt = $this->getAttributeValue(static::CREATED_AT);

        if ($createdAt->notEqualTo($ledgers->first()->properties[static::CREATED_AT])) {
            return false;
        }

        // The updated at value must match
        $updatedAt = $this->getAttributeValue(static::UPDATED_AT);

        if ($updatedAt->notEqualTo($ledgers->last()->properties[static::UPDATED_AT])) {
            return false;
        }

        $properties = [];

        $modifyingEvents = [
            'created',
            'updated',
            'deleted',
            'restored',
        ];

        foreach ($ledgers as $ledger) {
            // Ledgers cannot be tainted
            if ($ledger->isTainted()) {
                return false;
            }

            if (! \in_array($ledger->event, $modifyingEvents, true)) {
                continue;
            }

            $properties[] = $ledger->properties;
        }

        // Finally, compare the current properties with the compiled ones
        return \array_merge(...$properties) === $this->getAttributes();
    }
}
