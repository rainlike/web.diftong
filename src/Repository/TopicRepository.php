<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Topic;

use App\Repository\Library\Interfaces\ILast;
use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\ISeoable;
use App\Repository\Library\Interfaces\IExistForPortal;

use App\Repository\Library\Traits\Last as LastMethods;
use App\Repository\Library\Traits\Basic as BasicMethods;
use App\Repository\Library\Traits\Seoable as SeoableMethods;
use App\Repository\Library\Traits\ExistForPortal as ExistForPortalMethods;

/**
 * Class TopicRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository implements IBasic, ISeoable, ILast, IExistForPortal
{
    use LastMethods;
    use BasicMethods;
    use SeoableMethods;
    use ExistForPortalMethods;

    /**
     * TopicRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Topic::class);
    }
}
