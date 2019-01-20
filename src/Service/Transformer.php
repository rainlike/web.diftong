<?php
/**
 * Transformer Service
 * Provides useful methods for values transformation
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

use App\Service\Library\Magic\MagicCallable as MagicCallMethod;

/** Class Transformer */
class Transformer
{
    use MagicCallMethod;

    /**
     * Possible types to be transformed
     * @var array
     */
    public const TYPES = [
        self::TYPE_BOOL,
        self::TYPE_INT,
        self::TYPE_FLOAT,
        self::TYPE_DECIMAL,
        self::TYPE_STRING,
        self::TYPE_ARRAY,
        self::TYPE_DATE
    ];

    /**
     * Constants of possible types
     * @var string
     */
    public const TYPE_BOOL = 'bool';
    public const TYPE_INT = 'int';
    public const TYPE_FLOAT = 'float';
    public const TYPE_DECIMAL = 'decimal';
    public const TYPE_STRING = 'string';
    public const TYPE_ARRAY = 'array';
    public const TYPE_DATE = 'date';

    /**
     * Transform to preset type
     *
     * @param $value
     * @param string $type
     * @return mixed|null
     */
    public static function transform($value, string $type)
    {
        $type = \strtolower($type);
        if (!\in_array($type, self::TYPES)) {
            return null;
        }

        $caller = 'transformTo'.\ucfirst($type);

        return self::$caller($value);
    }

    /**
     * Transform value to bool
     *
     * @param mixed $value
     * @return bool
     */
    public static function transformToBool($value): bool
    {
        return (bool)$value;
    }

    /**
     * Transform value to int
     *
     * @param mixed $value
     * @return int
     */
    public static function transformToInt($value): int
    {
        return (int)$value;
    }

    /**
     * Transform value to float
     *
     * @param mixed $value
     * @return float
     */
    public static function transformToFloat($value): float
    {
        return (float)$value;
    }

    /**
     * Transform value to decimal
     *
     * @param mixed $value
     * @return float
     */
    public static function transformToDecimal($value): float
    {
        return (float)$value;
    }

    /**
     * Transform value to string
     *
     * @param mixed $value
     * @return string
     */
    public static function transformToString($value): string
    {
        return (string)$value;
    }

    /**
     * @TODO: do it
     * Transform value to array
     *
     * @param mixed $value
     * @return array
     */
    public static function transformToArray($value): array
    {
        return [];
    }

    /**
     * @TODO: do it
     * Transform value to DateTime
     *
     * @param mixed $value
     * @return \DateTime
     */
    public static function transformToDate($value): \DateTime
    {
        return new \DateTime();
    }
}
