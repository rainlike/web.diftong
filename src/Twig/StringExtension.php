<?php
/**
 * Twig String Extension
 * Provides useful methods with strings
 *
 * @package App\Twig
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

use App\Service\Library;

/** Class StringExtension */
class StringExtension extends AbstractExtension
{
    /** @var Library */
    private $library;

    /**
     * ArrayExtension constructor
     *
     * @param Library $library
     */
    public function __construct(Library $library)
    {
        $this->library = $library;
    }

    /**
     * Filters for Twig
     *
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return array(
            new TwigFilter('slug', array($this, 'getSlug'))
        );
    }

    /**
     * Functions for Twig
     *
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('_startWith', array($this, 'startWith'))
        );
    }

    /**
     * Return sluglify string
     *
     * @param string $name
     * @return string|null
     */
    public function slug(string $name): ?string
    {
        return $this->library->slug($name);
    }

    /**
     * Check if string starts with substring
     *
     * @param string|null $string
     * @param string $substring
     * @return bool
     */
    public function startWith(?string $string, string $substring): bool
    {
        return $string === null
            ? false
            : $this->library->startWith($string, $substring);
    }
}
