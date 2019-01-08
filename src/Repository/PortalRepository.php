<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Portal;

use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\ISeoable;

use App\Repository\Library\Traits\Basic as BasicMethods;
use App\Repository\Library\Traits\Seoable as SeoableMethods;
use App\Repository\Library\Traits\MagicCallable as MagicCallableMethod;

/**
 * Class PortalRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Portal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Portal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Portal[]    findAll()
 * @method Portal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortalRepository extends ServiceEntityRepository implements IBasic, ISeoable
{
    use BasicMethods;
    use SeoableMethods;
    use MagicCallableMethod;

    /**
     * PortalRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Portal::class);
    }
}
