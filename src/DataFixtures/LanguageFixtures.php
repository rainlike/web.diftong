<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Language;

/**
 * Class LanguageFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class LanguageFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of Languages
     * @var array
     */
    private static $languages = [
        [
            'locale' => 'uk',
            'icu' => 'uk_UA',
            'name' => 'ukrainian',
            'enabled' => true
        ],
        [
            'locale' => 'ru',
            'icu' => 'ru_RU',
            'name' => 'russian',
            'enabled' => true
        ],
        [
            'locale' => 'en',
            'icu' => 'en_US',
            'name' => 'english',
            'enabled' => false
        ],
        [
            'locale' => 'es',
            'icu' => 'es_ES',
            'name' => 'spanish',
            'enabled' => false
        ],
        [
            'locale' => 'pl',
            'icu' => 'pl_PL',
            'name' => 'polish',
            'enabled' => false
        ]
    ];

    /**
     * Load fixtures
     *
     * @param ObjectManager
     * @return void
     * @throws \BadMethodCallException
     */
    public function load(ObjectManager $manager): void
    {
        foreach (self::$languages as $language) {
            $entity = new Language();
            $entity->setLocale($language['locale']);
            $entity->setIcu($language['icu']);
            $entity->setName($language['name']);
            $entity->setEnabled($language['enabled']);
            $manager->persist($entity);

            $this->addReference('language-'.$language['locale'], $entity);
        }

        $manager->flush();
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
