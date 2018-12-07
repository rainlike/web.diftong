<?php
/**
 * Setting Twig Extension
 * Provides extensions for checking settings
 *
 * @package App\Twig
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Twig;

use Doctrine\ORM\NonUniqueResultException;

use Twig\Extension\AbstractExtension;

use Twig\TwigFunction;

use App\Service\Settings;

/** Class SettingExtension */
class SettingExtension extends AbstractExtension
{
    /** @var Settings */
    private $settings;

    /**
     * SettingExtension constructor
     *
     * @param Settings $settings
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Functions for Twig
     *
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('_setting', array($this, 'getSetting')),
        );
    }

    /**
     * Get enabled setting
     *
     * @param string $name
     * @return mixed|null
     * @throws NonUniqueResultException
     */
    public function getSetting(string $name)
    {
        return $this->settings->getSetting($name);
    }
}
