<?php
/**
 * Static Library
 * provides access to common static properties
 *
 * @package App\Utility
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Utility;

/** Class StaticStorage */
class StaticStorage
{
    /**
     * Get index for SEO translations
     *
     * @return string
     */
    public static function seoTransIndex(): string
    {
        return 'default';
    }

    /**
     * Get index for SEO translations of site name
     *
     * @return string
     */
    public static function seoTransSiteNameIndex(): string
    {
        return 'default.site_name';
    }

    /**
     * Get index for SEO translations of title
     *
     * @return string
     */
    public static function seoTransTitleIndex(): string
    {
        return 'default.title';
    }

    /**
     * Get index for SEO translations of description
     *
     * @return string
     */
    public static function seoTransDescriptionIndex(): string
    {
        return 'default.description';
    }

    /**
     * Get index for SEO translations of keywords
     *
     * @return string
     */
    public static function seoTransKeywordsIndex(): string
    {
        return 'default.keywords';
    }
}
