<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\TopicTheme;

use App\DataFixtures\Library\Traits\Translations as TranslationMethods;

use App\Service\Library;

/**
 * Class TopicThemeFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class TopicThemeFixtures extends Fixture implements OrderedFixtureInterface
{
    use TranslationMethods;

    /**
     * List of preset themes for topics
     * @var array
     */
    private static $themes = [
        [
            'title' => 'My life',
            'description' => 'Personal writings, stories about yourself, your family, pastime, vacations, hobbies, best friends. All topics in this section somehow relate directly to the identity of the narrator.',
            'uri' => 'my-life'
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
        $now = new \DateTime();

        foreach (self::$themes as $theme) {
            $entity = new TopicTheme();
            $entity->setTitle($theme['title']);
            $entity->setDescription($theme['description']);
            $entity->setUri($theme['uri']);
            $entity->setEnabled(true);
            $entity->setCreated($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('topic-theme-'.Library::slug($theme['title']), $entity);

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
