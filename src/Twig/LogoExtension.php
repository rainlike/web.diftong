<?php
/**
 * Logo Extension
 * Provides methods for rendering logo
 *
 * @package App\Twig
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Twig;

use Psr\Container\ContainerInterface as Container;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

use App\Service\Logotype;

/** Class LogoExtension */
class LogoExtension extends AbstractExtension
{
    /** @var Logotype */
    private $logotype;

    /**
     * LogoExtension constructor
     *
     * @param Logotype $logotype
     */
    public function __construct(Logotype $logotype)
    {
        $this->logotype = $logotype;
    }

    /**
     * Functions for Twig
     *
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('_logo', array($this, 'getLogo')),
            new TwigFunction('_verboseLogo', array($this, 'getVerboseLogo'))
        );
    }

    /**
     * Get logo
     *
     * @param null|string $type
     * @param bool $verbose
     * @return string|array
     */
    public function getLogo(?string $type = null, bool $verbose = false)
    {
        return $this->logotype->getLogo($type, $verbose);
    }

    /**
     * Get logo with verbose mod
     *
     * @param null|string $type
     * @return array
     */
    public function getVerboseLogo(?string $type = null): array
    {
        return $this->logotype->getVerboseLogo($type);
    }
}
