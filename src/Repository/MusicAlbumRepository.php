<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\MusicAlbum;

use App\Repository\Library\Interfaces\IBasic;

use App\Repository\Library\Traits\Basic as BasicMethods;

/**
 * Class MusicAlbumRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method MusicAlbum|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusicAlbum|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusicAlbum[]    findAll()
 * @method MusicAlbum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicAlbumRepository extends ServiceEntityRepository implements IBasic
{
    use BasicMethods;

    /**
     * MusicAlbumRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, MusicAlbum::class);
    }
}
