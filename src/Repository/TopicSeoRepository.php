<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\TopicSeo;

/**
 * Class TopicSeoRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method TopicSeo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TopicSeo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TopicSeo[]    findAll()
 * @method TopicSeo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicSeoRepository extends ServiceEntityRepository
{
    /**
     * TopicSeoRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, TopicSeo::class);
    }
}
