<?php
/**
 * Static Library
 * provides useful static methods
 *
 * @package App\Utility
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Utility;

use Doctrine\Common\Collections\ArrayCollection;

/** Class StaticLibrary */
class StaticLibrary
{
    /** STRING SECTION ************************************************************************************************/

    /**
     * Slug delimiter
     * @var string
     */
    public static $slug_delimiter = '-';

    /**
     * Flags for placeholders
     */
    /** @var int: flag clean placeholders */
    public static $flag_string_placeholders_clean = 1;
    /** @var int: flag framed placeholders */
    public static $flag_string_placeholders_framed = 2;
    /** @var int: flag clean and framed placeholders */
    public static $flag_string_placeholders_all = 3;
    /** @var int: flag count of placeholders */
    public static $flag_string_placeholders_count = 4;

    /**
     * FindStringPlaceholders default descriptors
     * @var array
     */
    public static $string_placeholders_default_descriptors = ['{{', '}}'];

    /**
     * Return slug string
     *
     * @param string|void
     * @return string|null
     */
    public static function slug(): ?string
    {
        $args = \func_get_args();
        $count = \func_num_args();
        $result = null;

        switch (true) {
            case $count === 0:
                break;
            case $count === 1:
                $result = \str_replace(' ', self::$slug_delimiter, \strtolower($args[0]));
                break;
            case $count > 1:
                $result = \implode(self::$slug_delimiter, $args);
                $result = \str_replace(' ', self::$slug_delimiter, \strtolower($result));
                break;
        }

        return $result;
    }

    /**
     * Get last char in string
     *
     * @param string $string
     * @return string
     */
    public static function lastChar(string $string): string
    {
        return \substr($string, -1);
    }

    /**
     * Generate random string
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function randomString(int $length = 10): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charsLength = \strlen($chars);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $chars[\random_int(0, $charsLength - 1)];
        }

        return $randomString;
    }

    /**
     * Convert snake to camel case
     *
     * @param $string
     * @param bool $capitalize
     * @return string|mixed
     */
    public static function snakeToCamelCase(string $string, bool $capitalize = false): string
    {
        $convertString = \str_replace(' ', '', \ucwords(\str_replace('_', ' ', $string)));

        if (!$capitalize) {
            $convertString[0] = \strtolower($convertString[0]);
        }

        return $convertString;
    }

    /**
     * Convert camel to snake case
     *
     * @param string $string
     * @return string
     */
    public static function camelToSnakeCase(string $string): string
    {
        \preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);

        if (\is_array($matches)) {
            $matchesList = $matches[0];

            /** @var array $matchesList */
            foreach ($matchesList as &$match) {
                $match = ($match === \strtoupper($match))
                    ? \strtolower($match)
                    : \lcfirst($match);
            }

            return \implode('_', $matchesList);
        }

        return $string;
    }

    /**
     * Check if string starts with substring
     *
     * @param string $string
     * @param string $subString
     * @return bool
     */
    public static function startWith(string $string, string $subString): bool
    {
        return \strpos($string, $subString) === 0;
    }

    /**
     * Return text with uppercase first char
     *
     * @param string $text
     * @return string
     */
    public static function upFirstChar(string $text): string
    {
        return \mb_strtoupper(\mb_substr($text, 0, 1)).\mb_substr($text, 1);
    }

    /**
     * Find placeholders in string
     *
     * @param string $string
     * @param array|null $descriptors
     * @param int|null $flag
     * @param bool $handling
     * @return int|array|null
     */
    public static function findStringPlaceholders(
        string $string,
        array $descriptors = null,
        ?int $flag = null,
        bool $handling = false
    ) {
        [$string, $descriptors, $failed] = self::stringPlaceholdersHandle($string, $handling, $descriptors);

        if ($failed) {
            return null;
        }

        $flag = (($flag === null) || !\in_array((int)$flag, [
                self::$flag_string_placeholders_clean,
                self::$flag_string_placeholders_framed,
                self::$flag_string_placeholders_all,
                self::$flag_string_placeholders_count
            ], false))
            ? self::$flag_string_placeholders_clean
            : (int)$flag;

        $regex = '~'.$descriptors[0].'([^'.self::lastChar($descriptors[0]).']+)'.$descriptors[1].'~';
        \preg_match_all($regex, $string, $placeholders);

        if (!$placeholders) {
            return null;
        }

        switch ($flag) {
            case self::$flag_string_placeholders_clean:
                $result = $placeholders[1];
                break;
            case self::$flag_string_placeholders_framed:
                $result = $placeholders[0];
                break;
            case self::$flag_string_placeholders_all:
                $result = $placeholders;
                break;
            case self::$flag_string_placeholders_count:
                $result = \count($placeholders[0]);
                break;
            default:
                $result = null;
        }

        return $result;
    }

    /**
     * Handling string and descriptors for findStringPlaceholders()
     *
     * @param string $string
     * @param bool $handling
     * @param array|null $descriptors
     * @return array
     */
    private static function stringPlaceholdersHandle(string $string, bool $handling, ?array $descriptors = null): array
    {
        $failed = false;

        switch (true) {
            case (($descriptors === null) && !$handling):
                $processedString = $string;
                $processedDescriptors = self::$string_placeholders_default_descriptors;
                break;

            case (($descriptors !== null) && self::isValidDescriptors($descriptors) && !$handling):
                $processedString = $string;
                $processedDescriptors = $descriptors;
                break;

            case (($descriptors === null) && $handling):
                $processedString = $string;
                $processedDescriptors = self::$string_placeholders_default_descriptors;
                $failed = true;
                break;

            case (($descriptors !== null) && self::isValidDescriptors($descriptors) && $handling):
                $processedString = \str_replace($descriptors, self::$string_placeholders_default_descriptors, $string);
                $processedDescriptors = self::$string_placeholders_default_descriptors;
                break;

            default:
                $processedString = $string;
                $processedDescriptors = $descriptors;
        }

        return [
            $processedString,
            $processedDescriptors,
            $failed
        ];
    }

    /**
     * Check validity of descriptors for findStringPlaceholders()
     *
     * @param array $descriptors
     * @return bool
     */
    private static function isValidDescriptors(array $descriptors): bool
    {
        return (
            ($descriptors !== null)
            && \is_array($descriptors)
            && (\count($descriptors) === 2)
            && self::arrayHasOnlyTypes($descriptors, 'string')
        );
    }

    /** ARRAY SECTION *************************************************************************************************/

    /**
     * Flags for arrayType
     */
    /** @var int: flag for arrayType - return string representation */
    public static $flag_array_type_string = 1;
    /** @var int: flag for arrayType - return numeric representation */
    public static $flag_array_type_numeric = 2;

    /**
     * Flags for isMaterialArray function
     */
    /** @var int: flag for isMaterialArray function - all values are numeric */
    public static $flag_is_material_array_number = 1;
    /** @var int: flag for isMaterialArray function - all values are string */
    public static $flag_is_material_array_string = 2;
    /** @var int: flag for isMaterialArray function - all values are array */
    public static $flag_is_material_array_list = 3;
    /** @var int: flag for isMaterialArray function - all values are any object */
    public static $flag_is_material_array_object = 4;
    /** @var int: flag for isMaterialArray function - all values are ArrayCollection instance */
    public static $flag_is_material_array_collection = 5;

    /**
     * Possible types of array items
     * @var array
     */
    public static $possible_array_items_types = [
        'boolean',
        'integer',
        'double',
        'string',
        'array',
        'object',
        'resource',
        'null'
    ];

    /**
     * Reset and shift array (simple function)
     *
     * @param array $array
     * @return array
     */
    public static function simpleArrayShift(array $array): array
    {
        \reset($array);
        \array_shift($array);

        return $array;
    }

    /**
     * Reset and shift array
     *
     * @param array $array
     * @param int|null $count
     * @return array
     */
    public static function arrayShift(array $array, ?int $count = null): array
    {
        if (($count !== null) && ($count === 0)) {
            return $array;
        }

        \reset($array);
        \array_shift($array);

        if ($count > 0) {
            return self::arrayShift($array, $count-1);
        }

        return $array;
    }

    /**
     * Check array is sequential
     *
     * @param array $array
     * @return bool
     */
    public static function isSequentialArray(array $array): bool
    {
        return (\array_keys($array) === \range(0, \count($array) - 1));
    }

    /**
     * Check array is associative
     *
     * @param array $array
     * @return bool
     */
    public static function isAssociativeArray(array $array): bool
    {
        return (\array_keys($array) !== \range(0, \count($array) - 1));
    }

    /**
     * Get array type
     *
     * @param array $array
     * @param int|null $flag
     * @return int|string
     */
    public static function arrayType(array $array, ?int $flag = null)
    {
        $flag = (($flag === null) || !\in_array($flag, [
                self::$flag_array_type_string,
                self::$flag_array_type_numeric
            ], false))
            ? self::$flag_array_type_string
            : (int)$flag;

        $isAssociative = self::isAssociativeArray($array);

        switch ($flag) {
            case self::$flag_array_type_string:
                $result = $isAssociative
                    ? 'associative'
                    : 'sequential';
                break;
            case self::$flag_array_type_numeric:
                $result = $isAssociative
                    ? 1
                    : 2;
                break;
            default:
                $result = null;
        }

        return $result;
    }

    /**
     * Check array has all keys or at least one
     *
     * @param int|string|array $keys
     * @param array $targetArray
     * @param bool $allKeys
     * @return bool
     */
    public static function arrayKeysExists($keys, array $targetArray, bool $allKeys = true): bool
    {
        if (!\is_int($keys) && !\is_string($keys) && !\is_array($keys)) {
            return false;
        }

        if (\is_int($keys) || \is_string($keys)) {
            return \array_key_exists($keys, $targetArray);
        } elseif (self::isAssociativeArray($keys)) {
            return false;
        } else {
            $keysCount = \count($keys);
            $targetCount = 0;

            foreach ((array)$keys as $key) {
                if (\array_key_exists($key, $targetArray)) {
                    $targetCount++;
                }
            }

            return $allKeys
                ? ($keysCount === $targetCount)
                : ($targetCount > 0);
        }
    }

    /**
     * Returns new array without matches
     *
     * @param array $sourceArray
     * @param array $excepts
     * @return array
     */
    public static function arrayExcept(array $sourceArray, array $excepts): array
    {
        if (self::isAssociativeArray($excepts)) {
            return $sourceArray;
        }

        $isAssociative = self::isAssociativeArray($sourceArray);
        $function = $isAssociative
            ? 'array_key_exists'
            : 'in_array';

        $processedArray = $sourceArray;
        foreach ($excepts as $except) {
            if (\call_user_func($function, $except, $processedArray)) {
                unset($processedArray[$isAssociative
                        ? $except
                        : \array_search($except, $processedArray)
                    ]);
            }
        }

        return $isAssociative
            ? $processedArray
            : \array_values($processedArray);
    }

    /**
     * Check array has values only this type
     *
     * @param array $array
     * @param string $type
     * @return bool|null
     */
    public static function arrayHasOnlyTypes(array $array, string $type): ?bool
    {
        if (!\in_array($type, self::$possible_array_items_types, false)) {
            return null;
        }

        foreach ($array as $item) {
            if (\strtolower(\gettype($item)) !== $type) {
                return false;
            }
        }

        return true;
    }

    /**
     * Transform associative array to sequential array
     *
     * @param array $array
     * @param string $glue
     * @return array
     */
    public static function transformToSequentialArray(array $array, string $glue): array
    {
        if (self::isSequentialArray($array)) {
            return $array;
        }

        $sequentialArray = [];
        foreach ($array as $item => $value) {
            $sequentialArray[] = $item.$glue.$value;
        }

        return $sequentialArray;
    }

    /**
     * Transform sequential array to associative array
     *
     * @param array $array
     * @return array
     */
    public static function transformToAssociativeArray(array $array): array
    {
        if (!self::isSequentialArray($array)) {
            return $array;
        }

        $result = [];

        foreach ($array as $item) {
            if (\is_string($item) || \is_int($item)) {
                $result[$item] = $item;
            }
        }

        return $result;
    }

    /**
     * Check if array has only material elements
     *
     * @param array $array
     * @param int|null $flag
     * @param bool $strict
     * @param bool $atLeastOne
     * @return bool
     */
    public static function isMaterialArray(
        array $array,
        ?int $flag = null,
        bool $strict = false,
        bool $atLeastOne = false
    ): bool
    {
        /**
         * Checker function
         *
         * @param mixed $value
         * @return bool
         */
        $checker = function ($value) use ($flag, $strict) {
            switch ($flag) {
                case self::$flag_is_material_array_number:
                    return $strict
                        ? \is_numeric($value) && $value !== 0
                        : \is_numeric($value);
                    break;
                case self::$flag_is_material_array_string:
                    return $strict
                        ? \is_string($value) && $value !== ''
                        : \is_string($value);
                    break;
                case self::$flag_is_material_array_list:
                    return $strict
                        ? \is_array($value) && !empty($value)
                        : \is_array($value);
                    break;
                case self::$flag_is_material_array_object:
                    return $strict
                        ? \is_object($value) && !empty((array)$value)
                        : \is_object($value);
                    break;
                case self::$flag_is_material_array_collection:
                    return $strict
                        ? $value instanceof ArrayCollection && !$value->isEmpty()
                        : $value instanceof ArrayCollection;
                    break;
                default:
                    return $strict
                        ? $value !== null
                        && $value !== 0
                        && $value !== ''
                        && !empty($value)
                        && !empty((array)$value)
                        && ($value instanceof ArrayCollection && !$value->isEmpty())
                        : $value !== null;
            }
        };

        foreach ($array as $item) {
            if ($checker($item) === $atLeastOne) {
                return $atLeastOne;
            }
        }

        return !$atLeastOne;
    }

    /**
     * Return array without blank items
     *
     * @param array $array
     * @param bool $noZero
     * @return array
     */
    public static function arrayMaterialItems(array $array, $noZero = true): array
    {
        $isAssociative = self::isAssociativeArray($array);
        foreach ($array as $item => $value) {
            if ($value === null
                || (\is_string($value) && ($value === ''))
                || (\is_array($value) && empty($value))
                || (\is_object($value) && empty((array)$value))
                || ($value instanceof ArrayCollection && $value->isEmpty())
                || ($noZero && \is_numeric($value) && $value === 0)
            ) {
                unset($array[$item]);
            }
        }

        return $isAssociative
            ? $array
            : \array_values($array);
    }

    /** URL SECTION ***************************************************************************************************/

    /**
     * Address begins with word
     *
     * @param string $url: full URL with protocol path
     * @param string $word
     * @return bool
     */
    public static function startInUrl(string $url, string $word): bool
    {
        $splitUrl = \explode('/', $url);

        return !(($splitUrl[4] === '') || ($splitUrl[4] !== $word));
    }

    /**
     * Cut query ($_GET) parameters from URL
     *
     * @param string $url: URL or URI allowed
     * @return array
     */
    public static function cutUrlQueryParameters(string $url): array
    {
        $parameters = [];

        $cutUrl = \explode('?', $url);

        if (\count($cutUrl) > 1) {
            $getParameters = \explode('&', $cutUrl[1]);

            foreach ($getParameters as $getParameter) {
                $couple = \explode('=', $getParameter);
                $parameters[$couple[0]] = $couple[1];
            }
        }

        return $parameters;
    }

    /** CLASS SECTION *************************************************************************************************/

    /**
     * Get pure name of class
     *
     * @param object $class
     * @return string
     */
    public static function className(object $class): string
    {
        $className = \get_class($class);

        $path = \explode('\\', $className);
        $count = \count($path);

        return $path[$count-1];
    }

    /**
     * Get pure class path
     *
     * @param object $class
     * @param bool $saveSlash
     * @return string
     */
    public static function classPath(object $class, bool $saveSlash = false): string
    {
        $className = \get_class($class);
        $proxyStr = $saveSlash ? 'Proxies\__CG__' : 'Proxies\__CG__\\';

        return str_replace($proxyStr, '', $className);
    }
}
