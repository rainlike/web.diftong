<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Portal;

use App\DataFixtures\Library\Traits\Mapping as MappingMethods;
use App\DataFixtures\Library\Traits\Translations as TranslationMethods;

/**
 * Class PortalFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class PortalFixtures extends Fixture implements OrderedFixtureInterface
{
    use MappingMethods;
    use TranslationMethods;

    /**
     * List of Portals
     * @var array
     */
    private static $portals = [
        [
            'title' => 'English',
            'full_title' => '@TODO',
            'name' => 'english',
            'uri' => '/english',
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Ingles',
                    'uk' => 'Англійська мова',
                    'ru' => 'Английский язык',
                    'pl' => 'Język angielski'
                ],
                'full_title' => [
                    'es' => 'Ingles en linea',
                    'uk' => 'Англійська мова онлайн',
                    'ru' => 'Английский язык онлайн',
                    'pl' => 'Język angielski online'
                ]
            ]
        ],
        [
            'title' => 'Spanish',
            'full_title' => '@TODO',
            'name' => 'spanish',
            'uri' => '/spanish',
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Español',
                    'uk' => 'Іспанська мова',
                    'ru' => 'Испанский язык',
                    'pl' => 'Język hiszpański'
                ],
                'full_title' => []
            ]
        ],
        [
            'title' => 'Ukrainian',
            'full_title' => '@TODO',
            'name' => 'ukrainian',
            'uri' => '/ukrainian',
            'enabled' => false,
            'translations' => [
                'title' => [
                    'es' => 'Ucraniano',
                    'uk' => 'Українська мова',
                    'ru' => 'Украинский язык',
                    'pl' => 'Język ukraiński'
                ],
                'full_title' => []
            ]
        ],
        [
            'title' => 'Russian',
            'full_title' => '@TODO',
            'name' => 'russian',
            'uri' => '/russian',
            'enabled' => false,
            'translations' => [
                'title' => [
                    'es' => 'Ruso',
                    'uk' => 'Російська мова',
                    'ru' => 'Русский язык',
                    'pl' => 'Język rosyjski'
                ],
                'full_title' => []
            ]
        ],
        [
            'title' => 'Polish',
            'full_title' => '@TODO',
            'name' => 'polish',
            'uri' => '/polish',
            'enabled' => false,
            'translations' => [
                'title' => [
                    'es' => 'Polaco',
                    'uk' => 'Польська мова',
                    'ru' => 'Польский язык',
                    'pl' => 'Język polski'
                ],
                'full_title' => []
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
            $entity->setTitle($portal['title']);
            $entity->setFullTitle($portal['full_title'] ?? null);
            $entity->setName($portal['name']);
            $entity->setUri($portal['uri']);
            $entity->setEnabled($portal['enabled']);
            $entity->setCreated($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('portal-'.$portal['name'], $entity);

            $manager->flush();

            /** @var array $translations */
            $translations = $portal['translations'];
            if ($translations) {
                $this->saveTranslations($translations, $entity, $manager);
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
