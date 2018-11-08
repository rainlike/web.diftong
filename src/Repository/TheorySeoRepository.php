<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\TheorySeo;

/**
 * Class TheorySeoRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method TheorySeo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TheorySeo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TheorySeo[]    findAll()
 * @method TheorySeo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheorySeoRepository extends ServiceEntityRepository
{
    /**
     * TheorySeoRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, TheorySeo::class);
    }
}
