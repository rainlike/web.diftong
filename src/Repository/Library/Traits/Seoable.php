<?php
declare(strict_types=1);

namespace App\Repository\Library\Traits;

use App\Entity\Seo;

use App\Entity\Library\Interfaces\ISeoable as ISeoableEntity;

/**
 * Trait Seoable
 *
 * @package App\Repository\Library\Traits
 */
trait Seoable
{
    /**
     * Get SEO
     *
     * @param ISeoableEntity $target
     * @return Seo|null
     */
    public function getSeo(ISeoableEntity $target): ?Seo
    {
        return null;
        # @TODO
//        $qb = $this->createQueryBuilder('seoable')
//            ->select('seoable')
//            ->where('work.resume = :resume')
//            ->setParameter('resume', $resume)
//            ->andWhere('work.enabled = :condition')
//            ->setParameter('condition', $condition)
//            ->addOrderBy('work.id', $order);
//
//        return $qb->getQuery()->getResult();
    }
}
