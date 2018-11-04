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
            'title' => 'English',
            'name' => 'english',
            'uri' => '/english',
            'enabled' => true,
            'translations' => [
                'es' => 'Ingles',
                'uk' => 'Англійська мова',
                'ru' => 'Английский язык',
                'pl' => 'Język angielski'
            ]
        ],
        [
            'title' => 'Spanish',
            'name' => 'spanish',
            'uri' => '/spanish',
            'enabled' => true,
            'translations' => [
                'es' => 'Español',
                'uk' => 'Іспанська мова',
                'ru' => 'Испанский язык',
                'pl' => 'Język hiszpański'
            ]
        ],
        [
            'title' => 'Ukrainian',
            'name' => 'ukrainian',
            'uri' => '/ukrainian',
            'enabled' => false,
            'translations' => [
                'es' => 'Ucraniano',
                'uk' => 'Українська мова',
                'ru' => 'Украинский язык',
                'pl' => 'Język ukraiński'
            ]
        ],
        [
            'title' => 'Russian',
            'name' => 'russian',
            'uri' => '/russian',
            'enabled' => false,
            'translations' => [
                'es' => 'Ruso',
                'uk' => 'Російська мова',
                'ru' => 'Русский язык',
                'pl' => 'Język rosyjski'
            ]
        ],
        [
            'title' => 'Polish',
            'name' => 'polish',
            'uri' => '/polish',
            'enabled' => false,
            'translations' => [
                'es' => 'Polaco',
                'uk' => 'Польська мова',
                'ru' => 'Польский язык',
                'pl' => 'Język polski'
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
            foreach ($translations as $locale => $translation) {
                $entity->setTranslatableLocale($locale);
                $entity->setTitle($translation);
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
