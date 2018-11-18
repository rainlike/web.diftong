<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Theory;

use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\ISeoable;

use App\Repository\Library\Traits\Enabled as EnabledMethods;
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
    use EnabledMethods;
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
}
