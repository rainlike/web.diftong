<?php
/**
 * Locale Trait
 * Provides methods for manage command output language
 *
 * @package App\Command\Library\Traits
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 diftong.com (https://www.diftong.com)
 * @author Alexander Saveliev <me@rainlike.com>
 */
declare(strict_types=1);

namespace App\Command\Library\Traits;

/** Trait LocaleTrait */
trait LocaleTrait
{
    /**
     * Default locale
     * @var string
     */
    public static $default_locale = 'en';

    /**
     * Certain locale
     * @var string
     */
    public static $locale = 'en';

    /**
     * Sent possible locales
     * @var array
     */
    public static $locales;

    /**
     * Set locale
     *
     * @param string $locale
     * @return void
     */
    protected function setLocale(string $locale): void
    {
        self::$locale = \in_array($locale, self::$locales)
            ? $locale
            : self::$default_locale;
    }
}
