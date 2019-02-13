<?php
/**
 * Setting Twig Extension
 * Provides extensions for checking settings
 *
 * @package App\Twig
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 diftong.com (https://www.diftong.com)
 * @author Alexander Saveliev <me@rainlike.com>
 */
declare(strict_types=1);

namespace App\Twig;

use Doctrine\ORM\NonUniqueResultException;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

use App\Entity\User;

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
     * @param User|null $user
     * @return mixed|null
     * @throws NonUniqueResultException
     */
    public function getSetting(string $name, ?User $user = null)
    {
        return $this->settings->getSetting($name, $user);
    }
}
