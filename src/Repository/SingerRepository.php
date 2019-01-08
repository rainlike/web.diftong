<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Singer;

use App\Repository\Library\Interfaces\IBasic;

use App\Repository\Library\Traits\Basic as BasicMethods;

/**
 * Class SingerRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Singer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Singer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Singer[]    findAll()
 * @method Singer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SingerRepository extends ServiceEntityRepository implements IBasic
{
    use BasicMethods;

    /**
     * SingerRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Singer::class);
    }
}
