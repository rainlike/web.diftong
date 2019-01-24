<?php
/**
 * Columns Trait
 * Share methods for extracting columns from entity
 *
 * @package App\Repository\Library\Traits
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Repository\Library\Traits;

use Doctrine\ORM\NonUniqueResultException;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

use App\Service\Library;

/** Trait Columns */
trait Columns
{
    /**
     * Get columns from entity
     *
     * @param int $id
     * @param array $columns
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function getColumns(int $id, array $columns): ?array
    {
        return $this->getColumnsQuery($id, $columns)->getOneOrNullResult();
    }

    /**
     * Get query for entity columns
     *
     * @param int $id
     * @param array $columns
     * @return Query
     */
    public function getColumnsQuery(int $id, array $columns): Query
    {
        if (Library::isAssociativeArray($columns)) {
            $select = 'target';
        } else {
            $select = [];
            foreach ($columns as $column) {
                $select[] = 'target.'.\strtolower($column);
            }
        }

        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('target')
            ->select($select)
            ->where('target.id = :target_id')
            ->setParameter('target_id', $id);

        return $qb->getQuery();
    }
}
