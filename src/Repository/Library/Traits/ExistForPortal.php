<?php
/**
 * ExistForPortal Trait
 * Share methods for checking of self-existing for portal
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

/** Trait ExistForPortal */
trait ExistForPortal
{
    /**
     * Check if at least one target of this record exist for portal
     *
     * @param int $id
     * @return bool
     * @throws NonUniqueResultException
     */
    public function existForPortal(int $id): ?bool
    {
        $dbResult = $this->existForPortalQuery($id)->getOneOrNullResult();

        return (bool)$dbResult;
    }

    /**
     * Get query for check that at least one target of this record exist for portal
     *
     * @param int $id
     * @return Query
     */
    public function existForPortalQuery(int $id): Query
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('target')
            ->select('target.id')
            ->where('target.portal = :portal_id')
            ->setParameter('portal_id', $id)
            ->setMaxResults(1);

        return $qb->getQuery();
    }
}
