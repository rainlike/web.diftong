<?php
declare(strict_types=1);

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\TopicTheme;

use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\ISeoable;

use App\Repository\Library\Traits\Enabled as EnabledMethods;
use App\Repository\Library\Traits\Seoable as SeoableMethods;

/**
 * Class TopicThemeRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method TopicTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method TopicTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method TopicTheme[]    findAll()
 * @method TopicTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicThemeRepository extends ServiceEntityRepository implements IBasic, ISeoable
{
    use EnabledMethods;
    use SeoableMethods;

    /**
     * TopicThemeRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, TopicTheme::class);
    }
}
