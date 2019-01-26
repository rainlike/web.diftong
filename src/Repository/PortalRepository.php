<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\ORM\Query;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Portal;

use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\ISeoable;

use App\Repository\Library\Traits\Basic as BasicMethods;
use App\Repository\Library\Traits\Seoable as SeoableMethods;

/**
 * Class PortalRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Portal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Portal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Portal[]    findAll()
 * @method Portal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortalRepository extends ServiceEntityRepository implements IBasic, ISeoable
{
    use BasicMethods;
    use SeoableMethods;

    /**
     * PortalRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Portal::class);
    }

    /**
     * Find Portal by ultimate URI
     *
     * @param string $uri
     * @param bool $enabledOnly
     * @return Portal|null
     * @throws NonUniqueResultException
     */
    public function findByUltimateUri(string $uri, bool $enabledOnly = true): ?Portal
    {
        return $this->findByUltimateUriQuery($uri, $enabledOnly)
            ->getOneOrNullResult();
    }

    /**
     * Get query got finding Portal by ultimate URI
     *
     * @param string $uri
     * @param bool $enabledOnly
     * @return Query
     */
    public function findByUltimateUriQuery(string $uri, bool $enabledOnly = true): Query
    {
        $qb = $this->createQueryBuilder('portal')
            ->select('portal')
            ->where('portal.uri = :portal_uri OR portal.slug = :portal_uri')
            ->setParameter('portal_uri', $uri);

        if ($enabledOnly) {
            $qb->andWhere('portal.enabled = :enabled_only')
                ->setParameter('enabled_only', $enabledOnly);
        }

        return $qb->getQuery();
    }
}
