<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Portal;

/**
 * Class PortalFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class PortalFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of Portals
     * @var array
     */
    private static $portals = [
        [
            'name' => 'Английский язык',
            'short_name' => 'english',
            'article_prefix' => 'eng',
            'url_prefix' => 'english',
            'enabled' => true,
            'translations' => [
                'uk' => 'Англійська мова',
                'en' => 'English',
                'es' => 'Idioma ingles'
            ]
        ],
        [
            'name' => 'Испанский язык',
            'short_name' => 'spanish',
            'article_prefix' => 'esp',
            'url_prefix' => 'spanish',
            'enabled' => true,
            'translations' => [
                'uk' => 'Іспанська мова',
                'en' => 'Spanish',
                'es' => 'Idioma español'
            ]
        ],
        [
            'name' => 'Русский язык',
            'short_name' => 'russian',
            'article_prefix' => 'rus',
            'url_prefix' => 'russian',
            'enabled' => false,
            'translations' => [
                'uk' => 'Російська мова',
                'en' => 'Russian',
                'es' => 'Idioma ruso'
            ]
        ],
        [
            'name' => 'Украинский язык',
            'short_name' => 'ukrainian',
            'article_prefix' => 'ukr',
            'url_prefix' => 'ukrainian',
            'enabled' => false,
            'translations' => [
                'uk' => 'Українська мова',
                'en' => 'Ukrainian',
                'es' => 'Idioma ucraniano'
            ]
        ]
    ];

    /**
     * Load fixtures
     *
     * @param ObjectManager $manager
     * @return void
     * @throws \BadMethodCallException
     */
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        foreach (self::$portals as $portal) {
            $entity = new Portal();
            $entity->setName($portal['name']);
            $entity->setShortName($portal['short_name']);
            $entity->setArticlePrefix($portal['article_prefix']);
            $entity->setUrlPrefix($portal['url_prefix']);
            $entity->setEnabled($portal['enabled']);
            $entity->setCreated($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('portal-'.$portal['short_name'], $entity);

            $manager->flush();

            /** @var array $translations */
            $translations = $portal['translations'];
            foreach ($translations as $locale => $translation) {
                $entity->setTranslatableLocale($locale);
                $entity->setName($translation);
                $manager->persist($entity);
                $manager->flush();
            }
        }
    }

    /**
     * Get fixture order
     *
     * @return int
     */
    public function getOrder(): int
    {
        return 1;
    }
}
