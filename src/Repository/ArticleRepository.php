<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Article;

use App\Repository\Library\Interfaces\ILast;
use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\ISeoable;
use App\Repository\Library\Interfaces\IExistForPortal;

use App\Repository\Library\Traits\Last as LastMethods;
use App\Repository\Library\Traits\Basic as BasicMethods;
use App\Repository\Library\Traits\Seoable as SeoableMethods;
use App\Repository\Library\Traits\ExistForPortal as ExistForPortalMethods;

/**
 * Class ArticleRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository implements IBasic, ISeoable, ILast
{
    use LastMethods;
    use BasicMethods;
    use SeoableMethods;
    use ExistForPortalMethods;

    /**
     * ArticleRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Article::class);
    }
}
