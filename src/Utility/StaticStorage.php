<?php
/**
 * Static Library
 * Provides access to common static properties
 *
 * @package App\Utility
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 diftong.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Utility;

/** Class StaticStorage */
class StaticStorage
{
    /**
     * Get outside link for logo
     *
     * @return string
     */
    public static function logoLink(): string
    {
        return 'https://vectr.com/tmp/c3t1Ik6b6/c1vRf5AZjh.svg?width=400&height=200&select=c1vRf5AZjhpage0';
    }

    /**
     * Get namespace prefix for entities
     *
     * @return string
     */
    public static function namespacePrefixEntity(): string
    {
        return 'App\Entity\\';
    }
}
