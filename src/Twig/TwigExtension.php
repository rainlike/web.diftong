<?php
/**
 * Common Twig Extension
 * Provides common useful methods
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

/** Class TwigExtension */
class TwigExtension extends AbstractExtension
{
    /** @var Container */
    private $container;

    /**
     * TwigExtension constructor
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Functions for Twig
     *
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('_hasParameter', array($this, 'hasParameter')),
            new TwigFunction('_getParameter', array($this, 'getParameter'))
        );
    }

    /**
     * Check if parameter exists
     *
     * @param string $parameter
     * @return bool
     */
    public function hasParameter(string $parameter): bool
    {
        return $this->container->hasParameter($parameter);
    }

    /**
     * Get parameter from Container
     *
     * @param string $parameter
     * @return mixed
     */
    public function getParameter(string $parameter)
    {
        return $this->container->hasParameter($parameter)
            ? $this->container->getParameter($parameter)
            : null;
    }
}
