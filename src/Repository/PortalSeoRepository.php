<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\PortalSeo;

/**
 * Class PortalSeoRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method PortalSeo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortalSeo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortalSeo[]    findAll()
 * @method PortalSeo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortalSeoRepository extends ServiceEntityRepository
{
    /**
     * PortalSeoRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, PortalSeo::class);
    }
}
