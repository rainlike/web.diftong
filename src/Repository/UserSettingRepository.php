<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\ORM\Query;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\User;
use App\Entity\UserSetting;

use App\Repository\Library\Interfaces\IBasic;
use App\Repository\Library\Interfaces\ISetting;

use App\Repository\Library\Traits\Basic as BasicMethods;

/**
 * Class UserSettingRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method UserSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSetting[]    findAll()
 * @method UserSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSettingRepository extends ServiceEntityRepository implements IBasic, ISetting
{
    use BasicMethods;

    /**
     * UserSettingRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, UserSetting::class);
    }

    /**
     * Get user setting by name
     *
     * @param string $setting
     * @param User $user
     * @param bool $enabledOnly
     * @return null|string
     * @throws NonUniqueResultException
     */
    public function getSetting(string $setting, User $user, bool $enabledOnly = true): ?string
    {
        return $this->getSettingQuery($setting, $user, $enabledOnly)->getSingleScalarResult();
    }

    /**
     * Get query for user setting by name
     *
     * @param string $setting
     * @param User $user
     * @param bool $enabledOnly
     * @return Query
     */
    public function getSettingQuery(string $setting, User $user, bool $enabledOnly = true): Query
    {
        $qb = $this->createQueryBuilder('user_setting')
            ->select('user_setting.value')
            ->leftJoin('user_setting.type', 'value_type')
            ->where('value_type.name = :type_name')
            ->setParameter('type_name', $setting)
            ->leftJoin('user_setting.user', 'user')
            ->where('user.id = :user_id')
            ->setParameter('user_id', $user->getId());

        if ($enabledOnly) {
            $qb->andWhere('value_type.enabled = :enabled_only')
                ->andWhere('user_setting.enabled = :enabled_only')
                ->setParameter('enabled_only', $enabledOnly);
        }

        return $qb->getQuery();
    }

    /**
     * Get full user setting entry by name
     *
     * @param string $setting
     * @param User $user
     * @param bool $enabledOnly
     * @return UserSetting|null
     * @throws NonUniqueResultException
     */
    public function getSettingRecord(string $setting, User $user, bool $enabledOnly = true): ?UserSetting
    {
        return $this->getSettingRecordQuery($setting, $user, $enabledOnly)->getOneOrNullResult();
    }

    /**
     * Get query for full user setting entry by name
     *
     * @param string $setting
     * @param User $user
     * @param bool $enabledOnly
     * @return Query
     */
    public function getSettingRecordQuery(string $setting, User $user, bool $enabledOnly = true): Query
    {
        $qb = $this->createQueryBuilder('user_setting')
            ->select('user_setting')
            ->leftJoin('user_setting.type', 'value_type')
            ->where('value_type.name = :type_name')
            ->setParameter('type_name', $setting)
            ->leftJoin('user_setting.user', 'user')
            ->where('user.id = :user_id')
            ->setParameter('user_id', $user->getId());

        if ($enabledOnly) {
            $qb->andWhere('value_type.enabled = :enabled_only')
                ->andWhere('user_setting.enabled = :enabled_only')
                ->setParameter('enabled_only', $enabledOnly);
        }

        return $qb->getQuery();
    }
}
