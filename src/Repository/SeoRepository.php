<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
     * Get target
     *
     * @param ISeoable $target
     * @return ISeoable|null
     */
    public function getTarget(ISeoable $target): ?ISeoable
    {
        # TODO
        return null;
    }
}
