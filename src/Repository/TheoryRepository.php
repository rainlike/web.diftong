<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;

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
            ->andWhere('theory.parent IS NULL')
            ->setParameter('portal_id', $portalId)
            ->setParameter('is_general', true);

        if ($enabledOnly) {
            $qb->andWhere('theory.enabled = :enabled_only')
                ->setParameter('enabled_only', $enabledOnly);
        }

        return $qb->getQuery();
    }

    /**
     * Get Theory by URI for Portal (optionally)
     *
     * @param string $uri
     * @param bool $enabledOnly
     * @param null|string $portalUri
     * @return Theory|null
     * @throws NonUniqueResultException
     */
    public function getTheoryByUri(
        string $uri,
        bool $enabledOnly = true,
        ?string $portalUri = null
    ): ?Theory
    {
        return $this->getTheoryByUriQuery($uri, $enabledOnly, $portalUri)
            ->getOneOrNullResult();
    }

    /**
     * Get query got getting theory by slug for Portal (optionally)
     *
     * @param string $uri
     * @param bool $enabledOnly
     * @param null|string $portalUri
     * @return Query
     */
    public function getTheoryByUriQuery(
        string $uri,
        bool $enabledOnly = true,
        ?string $portalUri = null
    ): Query
    {
        $qb = $this->createQueryBuilder('theory')
            ->select('theory')
            ->where('theory.uri = :theory_uri OR theory.slug = :theory_uri')
            ->setParameter('theory_uri', $uri);

        if ($portalUri) {
            $qb->join('theory.portal', 'portal')
                ->andWhere('portal.uri = :portal_uri OR portal.slug = :portal_uri')
                ->setParameter('portal_uri', $portalUri);
        }

        if ($enabledOnly) {
            $qb->andWhere('theory.enabled = :enabled_only')
                ->setParameter('enabled_only', $enabledOnly);
        }

        return $qb->getQuery();
    }

    /**
     * Get table of contents for portal
     *
     * @param int $portalId
     * @param bool $enabledOnly
     * @return array|null
     */
    public function getPortalTheoriesTree(int $portalId, bool $enabledOnly = true): ?array
    {
        $generalTheories = $this->getGeneralTheories($portalId, $enabledOnly);

        foreach ($generalTheories as $key => $generalTheory) {
            $generalTheories[$key]['children'] = $this->getAllChildren($generalTheory['id'], $enabledOnly);
        }

        return $generalTheories;
    }

    /**
     * Get all theory' children
     *
     * @param int $parentId
     * @param bool $enabledOnly
     * @return array|null
     */
    private function getAllChildren(int $parentId, bool $enabledOnly = true): ?array
    {
        $children = $this->getChildren($parentId, $enabledOnly);

        if ($children) {
            foreach ($children as $key => $child) {
                $children[$key]['children'] = $child['id']
                    ? $this->getAllChildren($child['id'], $enabledOnly)
                    : null;
            }
        }

        return $children;
    }

    /**
     * Get first line children of theory
     *
     * @param int $parentId
     * @param bool $enabledOnly
     * @return array|null
     */
    private function getChildren(int $parentId, bool $enabledOnly = true): ?array
    {
        $qb = $this->createQueryBuilder('theory')
            ->select([
                'theory.id',
                'theory.title',
                'theory.caption',
                'theory.uri',
                'theory.slug'
            ])
            ->where('theory.parent = :parent_id')
            ->setParameter('parent_id', $parentId);

        if ($enabledOnly) {
            $qb->andWhere('theory.enabled = :enabled_only')
                ->setParameter('enabled_only', $enabledOnly);
        }

        $children = $qb->getQuery()->getArrayResult();

        return $children ?: null;
    }
}
