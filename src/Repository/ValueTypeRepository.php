<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\ValueType;

use App\Repository\Library\Interfaces\IBasic;

use App\Repository\Library\Traits\Enabled as EnabledMethods;

/**
 * Class ValueTypeRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method ValueType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValueType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValueType[]    findAll()
 * @method ValueType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValueTypeRepository extends ServiceEntityRepository implements IBasic
{
    use EnabledMethods;

    /**
     * ValueTypeRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, ValueType::class);
    }
}
