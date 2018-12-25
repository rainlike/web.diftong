<?php
/**
 * Last Trait
 * Share methods for getting the last record
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

use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\Interfaces\ILastable;

/** Trait Last */
trait Last
{
    /**
     * Get the last record
     *
     * @return ILastable|null
     * @throws NonUniqueResultException
     */
    public function getLast(): ?ILastable
    {
        return $this->getLastQuery()->getOneOrNullResult();
    }

    /**
     * Get query for getting last record
     *
     * @return Query
     */
    public function getLastQuery(): Query
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('target')
            ->setMaxResults(1)
            ->orderBy('target.id', 'DESC');

        return $qb->getQuery();
    }

    /**
     * Get lasts records
     *
     * @param int $count
     * @return array|ArrayCollection
     */
    public function getLasts(int $count)
    {
        return $this->getLastsQuery($count)->getResult();
    }

    /**
     * Get query for getting lasts records
     *
     * @param int $count
     * @return Query
     */
    public function getLastsQuery(int $count): Query
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('target')
            ->setMaxResults($count)
            ->orderBy('target.id', 'DESC');

        return $qb->getQuery();
    }
}
