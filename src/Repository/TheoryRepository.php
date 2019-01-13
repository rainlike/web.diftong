<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\ORM\Query;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Theory;

use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\ISeoable;

use App\Repository\Library\Traits\Basic as BasicMethods;
use App\Repository\Library\Traits\Seoable as SeoableMethods;

/**
 * Class TheoryRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Theory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theory[]    findAll()
 * @method Theory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheoryRepository extends ServiceEntityRepository implements IBasic, ISeoable
{
    use BasicMethods;
    use SeoableMethods;

    /**
     * TheoryRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Theory::class);
    }

    /**
     * Get general theories
     *
     * @param int $portalId
     * @param bool $enabledOnly
     * @return array|ArrayCollection|mixed
     */
    public function getGeneralTheories(int $portalId, bool $enabledOnly = true)
    {
        return $this->getGeneralTheoriesQuery($portalId, $enabledOnly)->getResult();
    }

    /**
     * Get query for general theories
     *
     * @param int $portalId
     * @param bool $enabledOnly
     * @return Query
     */
    public function getGeneralTheoriesQuery(int $portalId, bool $enabledOnly = true): Query
    {
        $qb = $this->createQueryBuilder('theory')
            ->select([
                'theory.id',
                'theory.title',
                'theory.caption',
                'theory.uri',
                'theory.slug'
            ])
            ->where('theory.portal = :portal_id')
            ->andWhere('theory.isGeneral = :is_general')
            ->setParameter('portal_id', $portalId)
            ->setParameter('is_general', true);

        if ($enabledOnly) {
            $qb->andWhere('theory.enabled = :enabled_only')
                ->setParameter('enabled_only', $enabledOnly);
        }

        return $qb->getQuery();
    }
}
