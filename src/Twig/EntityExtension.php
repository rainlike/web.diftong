<?php
/**
 * Twig Entity Extension
 * Provides useful methods with entities
 *
 * @package App\Twig
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Twig;

use Doctrine\ORM\PersistentCollection;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

use App\Service\Library;

/** Class EntityExtension */
class EntityExtension extends AbstractExtension
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
            new TwigFilter('_collectionToString', array($this, 'transformCollectionToString'))
        );
    }

    /**
     * Convert PersistentCollection to string
     *
     * @param PersistentCollection $collection
     * @param string $field
     * @param string $delimiter
     * @return string
     */
    public function transformCollectionToString(
        PersistentCollection $collection,
        string $field = 'name',
        string $delimiter = ','
    ): string
    {
        if ($collection->isEmpty()) {
            return '';
        }

        $result = '';
        $count = \count($collection);
        $iterator = 0;
        $namesCollection = [];

        foreach ($collection as $entity) {
            $getter = 'get'.\ucfirst($field);
            $namesCollection[] = $entity->$getter();
        }
        \natcasesort($namesCollection);

        foreach ($namesCollection as $item) {
            $iterator++;
            $result .= $item;

            if ($count > $iterator) {
                $result .= $delimiter.' ';
            }
        }

        return $result;
    }
}
