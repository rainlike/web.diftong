<?php
/**
 * Twig Array Extension
 * Provides useful methods with array
 *
 * @package App\Twig
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

use App\Service\Library;

/** Class ArrayExtension */
class ArrayExtension extends AbstractExtension
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
     * Functions for Twig
     *
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('_arrayExcept', array($this, 'arrayExcept'))
        );
    }

    /**
     * Return new array without matches
     *
     * @param array $sourceArray
     * @param array $excepts
     * @return array
     */
    public function arrayExcept(array $sourceArray, array $excepts): array
    {
        return $this->library->arrayExcept($sourceArray, $excepts);
    }
}
