<?php

declare(strict_types=1);

namespace Altek\Accountant\Exceptions;

use Throwable;

class DecipherException extends AccountantException
{
    /**
     * Ciphered value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * {@inheritdoc}
     */
    public function __construct($message, $value, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->value = $value;
    }

    /**
     * Get the ciphered value.
     *
     * @return mixed
     */
    public function getCipheredValue()
    {
        return $this->value;
    }
}
