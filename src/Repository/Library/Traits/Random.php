<?php
/**
 * Random Trait
 * Share methods for getting randomly records
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

use App\Entity\Library\Interfaces\IRandomly;

/** Trait Random */
trait Random
{
    /**
     * Get random record
     *
     * @return IRandomly|null
     * @throws NonUniqueResultException
     */
    public function getRandom(): ?IRandomly
    {
        $dbIds = $this->createQueryBuilder('target')
            ->select('target.id')
            ->where('target.enabled = :condition')
            ->setParameter('condition', true)
            ->getQuery()
            ->getResult();

        $ids = \array_column($dbIds, 'id');
        \shuffle($ids);
        $randomId = \end($ids);

        return $this->createQueryBuilder('target')
            ->select('target')
            ->where('target.id = :random_id')
            ->setParameter('random_id', $randomId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
