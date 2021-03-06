<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Portal;

use App\DataFixtures\Library\Traits\Translations as TranslationMethods;

use App\Service\Library;

/**
 * Class PortalFixtures
 * Fixtures for Portals
 *
 * @package App\DataFixtures
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class PortalFixtures extends Fixture implements OrderedFixtureInterface
{
    use TranslationMethods;

    /**
     * List of preset Portals
     * @var array
     */
    private static $portals = [
        [
            'title' => 'English',
            'caption' => '@CAPTION',
            'preview' => '@PREVIEW',
            'description' => '@DESCRIPTION',
            'language' => 'en',
            'uri' => 'english',
            'enabled' => true
        ],
        [
            'title' => 'Spanish',
            'caption' => '@CAPTION',
            'preview' => '@PREVIEW',
            'description' => '@DESCRIPTION',
            'language' => 'es',
            'uri' => 'spanish',
            'enabled' => true
        ],
        [
            'title' => 'Ukrainian',
            'caption' => '@CAPTION',
            'preview' => '@PREVIEW',
            'description' => '@DESCRIPTION',
            'language' => 'uk',
            'uri' => 'ukrainian',
            'enabled' => false
        ],
        [
            'title' => 'Russian',
            'caption' => '@CAPTION',
            'preview' => '@PREVIEW',
            'description' => '@DESCRIPTION',
            'language' => 'ru',
            'uri' => 'russian',
            'enabled' => false
        ],
        [
            'title' => 'Polish',
            'caption' => '@CAPTION',
            'preview' => '@PREVIEW',
            'description' => '@DESCRIPTION',
            'language' => 'pl',
            'uri' => 'polish',
            'enabled' => false
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
            $entity->setCaption($portal['caption']);
            $entity->setPreview($portal['preview']);
            $entity->setDescription($portal['description']);
            $entity->setUri($portal['uri'] ?? null);

            $entity->setLanguage($this->getReference('language-'.\strtolower($portal['language'])));

            $entity->setEnabled($portal['enabled']);
            $entity->setCreated($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('portal-'.Library::slug($portal['title']), $entity);

            $manager->flush();

            /** @var array $translations */
            $translations = $portal['translations'] ?? null;
            if ($translations) {
                $this->saveAllTranslations($translations, $entity, $manager);
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
