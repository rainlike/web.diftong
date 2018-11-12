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

/** Class StaticLibrary */
class StaticLibrary
{
    /**
     * Get pure name of class
     *
     * @param string $className
     * @return string
     */
    public static function className(string $className): string
    {
        $path = \explode('\\', $className);
        $count = \count($path);

        return $path[$count-1];
    }

    /**
     * Get pure class path
     *
     * @param string $className
     * @param bool $saveSlash
     * @return string
     */
    public static function classPath(string $className, bool $saveSlash = false): string
    {
        $proxyStr = $saveSlash ? 'Proxies\__CG__' : 'Proxies\__CG__\\';

        return str_replace($proxyStr, '', $className);
    }
}
