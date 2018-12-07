<?php
declare(strict_types=1);

namespace App\Repository\Library\Traits;

use Doctrine\ORM\NonUniqueResultException;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Trait Enabled
 *
 * @package App\Repository\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Enabled
{
    /**
     * Get enabled records
     *
     * @return array|null|mixed
     */
    public function getEnabled(): ?array
    {
        return $this->getEnabledQuery()->getResult();
    }

    /**
     * Get query for enabled records
     *
     * @return Query
     */
    public function getEnabledQuery(): Query
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('target')
            ->select('target')
            ->where('target.enabled = :enabled')
            ->setParameter('enabled', true);

        return $qb->getQuery();
    }

    /**
     * Get enabled record
     *
     * @param string $targetField
     * @param string $targetValue
     * @return mixed|null
     * @throws NonUniqueResultException
     */
    public function findEnabled(string $targetField, string $targetValue)
    {
        return $this->findEnabledQuery($targetField, $targetValue)->getOneOrNullResult();
    }

    /**
     * Get query for enabled record
     *
     * @param string $targetField
     * @param string $targetValue
     * @return Query
     */
    public function findEnabledQuery(string $targetField, string $targetValue): Query
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('target')
            ->select('target')
            ->where('target.'.(string)$targetField.' = :value')
            ->setParameter('value', $targetValue)
            ->andWhere('target.enabled = :enabled')
            ->setParameter('enabled', true);

        return $qb->getQuery();
    }
}
