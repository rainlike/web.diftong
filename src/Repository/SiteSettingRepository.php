<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\ORM\Query;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\SiteSetting;

use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\ISetting;

use App\Repository\Library\Traits\Enabled as EnabledMethods;

/**
 * Class SiteSettingRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method SiteSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteSetting[]    findAll()
 * @method SiteSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteSettingRepository extends ServiceEntityRepository implements IBasic, ISetting
{
    use EnabledMethods;

    /**
     * SiteSettingRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, SiteSetting::class);
    }

    /**
     * Get site setting by name
     *
     * @param string $setting
     * @param bool $enabledOnly
     * @return string|null
     * @throws NonUniqueResultException
     */
    public function getSetting(string $setting, bool $enabledOnly = true): ?string
    {
        return $this->getSettingQuery($setting, $enabledOnly)->getSingleScalarResult();
    }

    /**
     * Get query for site setting by name
     *
     * @param string $setting
     * @param bool $enabledOnly
     * @return Query
     */
    public function getSettingQuery(string $setting, bool $enabledOnly = true): Query
    {
        $qb = $this->createQueryBuilder('site_setting')
            ->select('site_setting.value')
            ->leftJoin('site_setting.type', 'value_type')
            ->where('value_type.name = :type_name')
            ->setParameter('type_name', $setting);

        if ($enabledOnly) {
            $qb->andWhere('value_type.enabled = :enabled_only')
               ->andWhere('site_setting.enabled = :enabled_only')
               ->setParameter('enabled_only', $enabledOnly);
        }

        return $qb->getQuery();
    }

    /**
     * Get full site setting entry by name
     *
     * @param string $setting
     * @param bool $enabledOnly
     * @return SiteSetting|null
     * @throws NonUniqueResultException
     */
    public function getSettingRecord(string $setting, bool $enabledOnly = true): ?SiteSetting
    {
        return $this->getSettingRecordQuery($setting, $enabledOnly)->getOneOrNullResult();
    }

    /**
     * Get query for full site setting entry by name
     *
     * @param string $setting
     * @param bool $enabledOnly
     * @return Query
     */
    public function getSettingRecordQuery(string $setting, bool $enabledOnly = true): Query
    {
        $qb = $this->createQueryBuilder('site_setting')
            ->select('site_setting')
            ->leftJoin('site_setting.type', 'value_type')
            ->where('value_type.name = :type_name')
            ->setParameter('type_name', $setting);

        if ($enabledOnly) {
            $qb->andWhere('value_type.enabled = :enabled_only')
                ->andWhere('site_setting.enabled = :enabled_only')
                ->setParameter('enabled_only', $enabledOnly);
        }

        return $qb->getQuery();
    }
}
