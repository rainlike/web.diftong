<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\ORM\Query;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Utility\StaticLibrary;

use App\Entity\Seo;

use App\Entity\Library\Interfaces\ISeoable;

/**
 * Class SeoRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Seo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seo[]    findAll()
 * @method Seo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeoRepository extends ServiceEntityRepository
{
    /**
     * SeoRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Seo::class);
    }

    /**
     * Get target SEO
     *
     * @param ISeoable $target
     * @return ISeoable|null
     * @throws NonUniqueResultException
     */
    public function getSeo(ISeoable $target): ?ISeoable
    {
        return $this->getSeoQuery($target)->getOneOrNullResult();
    }

    /**
     * Get query for target SEO
     *
     * @param ISeoable $target
     * @return Query
     */
    public function getSeoQuery(ISeoable $target)
    {
        $qb = $this->createQueryBuilder('seo')
            ->select('seo')
            ->where('seo.targetId = :targetId')
            ->andWhere('seo.targetName = :targetName')
            ->setParameter('targetId', $target->getId())
            ->setParameter('targetName', StaticLibrary::className($target));

        return $qb->getQuery();
    }
}
