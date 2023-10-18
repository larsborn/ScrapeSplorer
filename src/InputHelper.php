<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;
use function is_array;
use function is_bool;
use function is_float;
use function is_int;
use function is_numeric;
use function is_string;

final class InputHelper
{
    /**
     * @param mixed $value
     */
    public static function string($value): string
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException($value, 'string');
        }

        return $value;
    }

    /**
     * @param mixed $value
     */
    public static function int($value): int
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException($value, 'integer');
        }

        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return array<mixed, mixed>
     */
    public static function array($value): array
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException($value, 'array');
        }

        return $value;
    }

    /**
     * @param mixed $value
     */
    public static function bool($value): bool
    {
        if (!is_bool($value)) {
            throw new InvalidArgumentException($value, 'boolean');
        }

        return $value;
    }

    /**
     * @param mixed $value
     */
    public static function float($value): float
    {
        if (!is_float($value)) {
            throw new InvalidArgumentException($value, 'float');
        }

        return $value;
    }

    /**
     * @param mixed $value
     */
    public static function numeric($value): float
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException($value, 'float');
        }

        return (float) $value;
    }

    /**
     * @param mixed $value
     *
     * @psalm-return numeric-string
     */
    public static function numericString($value): string
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException($value, 'numeric-string');
        }

        return (string) $value;
    }

    /**
     * @param mixed $value
     */
    public static function nullableString($value): ?string
    {
        if ($value === null) {
            return null;
        }

        return self::string($value);
    }

    /**
     * @param mixed $value
     */
    public static function nullableInt($value): ?int
    {
        if ($value === null) {
            return null;
        }

        return self::int($value);
    }

    /**
     * @param mixed $value
     *
     * @return array<mixed, mixed>|null
     */
    public static function nullableArray($value): ?array
    {
        if ($value === null) {
            return null;
        }

        return self::array($value);
    }

    /**
     * @param mixed $value
     */
    public static function nullableFloat($value): ?float
    {
        if ($value === null) {
            return null;
        }

        return self::float($value);
    }

    /**
     * @param mixed $value
     */
    public static function dateTimeImmutable($value): DateTimeImmutable
    {
        if ($value instanceof DateTimeImmutable === false) {
            throw new InvalidArgumentException($value, DateTimeImmutable::class);
        }

        return $value;
    }

    /**
     * @param mixed $value
     */
    public static function nullableDateTimeImmutable($value): ?DateTimeImmutable
    {
        if ($value === null) {
            return null;
        }

        return self::dateTimeImmutable($value);
    }

    /**
     * @template T
     *
     * @param mixed           $value
     * @param class-string<T> $type
     *
     * @return T
     */
    public static function type($value, string $type)
    {
        if ($value instanceof $type === false) {
            throw new InvalidArgumentException($value, $type);
        }

        return $value;
    }

    /**
     * @template T
     *
     * @param mixed           $value
     * @param class-string<T> $type
     *
     * @return T|null
     */
    public static function nullableType($value, string $type)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof $type === false) {
            throw new InvalidArgumentException($value, $type);
        }

        return $value;
    }
}
