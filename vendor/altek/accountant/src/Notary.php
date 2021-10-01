<?php

declare(strict_types=1);

namespace Altek\Accountant;

class Notary implements Contracts\Notary
{
    /**
     * Determine if an array is indexed.
     *
     * @param array $data
     *
     * @return bool
     */
    public static function isIndexed(array $data): bool
    {
        return \array_keys($data) === \range(0, \count($data) - 1);
    }

    /**
     * Sort a multidimensional array.
     *
     * @param array $data
     *
     * @return void
     */
    public static function sort(array &$data): void
    {
        foreach ($data as $key => $value) {
            if (\is_array($value) && $value) {
                static::sort($data[$key]);
            }
        }

        static::isIndexed($data) ? \sort($data) : \ksort($data);
    }

    /**
     * {@inheritdoc}
     */
    public static function sign(array $data): string
    {
        static::sort($data);

        return \hash('sha512', \json_encode($data, JSON_NUMERIC_CHECK));
    }

    /**
     * {@inheritdoc}
     */
    public static function validate(array $data, string $signature): bool
    {
        return static::sign($data) === $signature;
    }
}
