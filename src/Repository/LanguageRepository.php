<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Language;

use App\Repository\Library\Traits\Basic as BasicMethods;

use App\Repository\Library\Interfaces\IBasic;

/**
 * Class LanguageRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Language|null find($id, $lockMode = null, $lockVersion = null)
 * @method Language|null findOneBy(array $criteria, array $orderBy = null)
 * @method Language[]    findAll()
 * @method Language[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LanguageRepository extends ServiceEntityRepository implements IBasic
{
    use BasicMethods;

    /**
     * LanguageRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Language::class);
    }

    /**
     * Get Language by locale
     *
     * @param string $locale
     * @return Language|null
     * @throws NonUniqueResultException
     */
    public function getLanguageByLocale(string $locale): ?Language
    {
        $qb = $this->createQueryBuilder('language')
            ->select('language')
            ->where('language.locale = :locale')
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Get enabled Languages for site
     *
     * @param string|null $sort
     * @param string|null $field
     * @return array|null
     */
    public function getEnabledLanguages(?string $sort = null, ?string $field = null): ?array
    {
        $checkSortBy = false;
        $checkField = true;
        $neededFiled = 'language.id';
        $condition = true;

        if ($sort && (($sort === 'DESC') || ($sort === 'ASC'))) {
            $checkSortBy = true;
        }

        if ($field) {
            $neededFiled = 'language.'.$field;
        }

        $qb = $this->createQueryBuilder('language')
            ->select('language')
            ->where('language.enabled = :condition')
            ->setParameter('condition', $condition);

        if ($checkSortBy && $checkField) {
            $qb->addOrderBy($neededFiled, $sort);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Get enabled locales for site
     *
     * @param string|null $sort
     * @return array
     */
    public function getEnabledLocales(?string $sort = null): array
    {
        $locales = [];
        $languages = $this->getEnabled();

        if ($languages) {
            /** @var Language $language */
            foreach ($languages as $language) {
                $locales[] = $language->getLocale();
            }

            if ($sort) {
                switch($sort) {
                    case 'ASC':
                        \asort($locales);
                        break;
                    case 'DESC':
                    default:
                        \arsort($locales);
                }
            }
        }

        return $locales;
    }

    /**
     * Get remaining locales except current
     *
     * @param string $locale
     * @param bool $enabledOnly
     * @return array|null
     */
    public function getRemainingLocales(string $locale, bool $enabledOnly = true): ?array
    {
        $qb = $this->createQueryBuilder('language')
            ->select('language.locale')
            ->where('language.locale != :locale')
            ->setParameter('locale', $locale);

        if ($enabledOnly) {
            $qb->andWhere('language.enabled = :enabled_only')
               ->setParameter('enabled_only', $enabledOnly);
        }

        return $qb->getQuery()->getResult();
    }
}
