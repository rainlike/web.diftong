<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Lyric;

use App\Repository\Library\Interfaces\IBasic;

use App\Repository\Library\Traits\Basic as BasicMethods;

/**
 * Class LyricRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Lyric|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lyric|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lyric[]    findAll()
 * @method Lyric[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LyricRepository extends ServiceEntityRepository implements IBasic
{
    use BasicMethods;

    /**
     * LyricRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Lyric::class);
    }
}
