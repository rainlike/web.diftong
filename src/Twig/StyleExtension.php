<?php
/**
 * Style Twig Extension
 * Defines styles & classes for HTML elements
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

use Psr\Container\ContainerInterface as Container;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

use App\Service\Settings;

use App\Entity\Storage\ValueTypeStorage;

/** Class StyleExtension */
class StyleExtension extends AbstractExtension
{
    /** @var Container */
    private $container;

    /** @var Settings */
    private $settings;

    /**
     * Marks for classes & styles
     * @var string
     */
    public const CLASS_HEADER_BUTTON = 'header_button';

    /**
     * StyleExtension constructor
     *
     * @param Container $container
     * @param Settings $settings
     */
    public function __construct(
        Container $container,
        Settings $settings
    ) {
        $this->container = $container;
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
            new TwigFunction('_class', array($this, 'getClass'))
        );
    }

    /**
     * Get CSS class for element
     *
     * @param string $mark
     * @return string
     * @throws NonUniqueResultException
     */
    public function getClass(string $mark): string
    {
        switch ($mark) {
            case self::CLASS_HEADER_BUTTON:
                $class = 'app-header__button';
                $isFlat = $this->settings->getSetting(ValueTypeStorage::HEADER_FLAT_ACTIONS);

                return $isFlat
                    ? $class.' app-header__button--flat'
                    : $class;

                break;
        }

        return '';
    }
}
