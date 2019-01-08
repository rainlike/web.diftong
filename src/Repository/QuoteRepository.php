<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Quote;

use App\Repository\Library\Traits\Basic as BasicMethods;
use App\Repository\Library\Traits\Random as RandomMethods;

use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\IRandom;

/**
 * Class QuoteRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Quote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quote[]    findAll()
 * @method Quote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuoteRepository extends ServiceEntityRepository implements IBasic, IRandom
{
    use BasicMethods;
    use RandomMethods;

    /**
     * QuoteRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Quote::class);
    }
}
