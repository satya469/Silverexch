<?php

declare(strict_types=1);

namespace Altek\Accountant\Contracts;

interface Identifiable
{
    /**
     * Get a unique identifier.
     *
     * @return mixed
     */
    public function getIdentifier();

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass();
}
