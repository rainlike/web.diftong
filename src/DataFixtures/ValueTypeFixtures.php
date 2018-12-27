<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\ValueType;

use App\DataFixtures\Library\Traits\Translations as TranslationMethods;

/**
 * Class ValueTypeFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class ValueTypeFixtures extends Fixture implements OrderedFixtureInterface
{
    use TranslationMethods;

    /**
     * List of preset ValueTypes
     * @var array
     */
    private static $valueTypes = [
        [
            'name' => 'global_show_topbar',
            'title' => 'Show topbar',
            'type' => ValueType::TYPE_BOOL,
            'region' => ValueType::REGION_GLOBAL,
            'priority' => ValueType::PRIORITY_USER,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar barra superior',
                    'uk' => 'Показати верхній бар',
                    'ru' => 'Показать верхнюю панель',
                    'pl' => 'Pokaż górny pasek'
                ]
            ]
        ],
        [
            'name' => 'global_logo_as_link',
            'title' => 'Header logo as link',
            'type' => ValueType::TYPE_BOOL,
            'region' => ValueType::REGION_GLOBAL,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Logo del panel superior como enlace',
                    'uk' => 'Логотип верхньої панелі як посилання',
                    'ru' => 'Логотип верхней панели как ссылка',
                    'pl' => 'Logo górnego panelu jako link'
                ]
            ]
        ],
        [
            'name' => 'menu_show_phonetics',
            'title' => 'Show phonetics section in menu',
            'type' => ValueType::TYPE_BOOL,
            'region' => ValueType::REGION_GLOBAL,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => '',
                    'uk' => '',
                    'ru' => '',
                    'pl' => ''
                ]
            ]
        ],
        [
            'name' => 'menu_show_lexis',
            'title' => 'Show lexis section in menu',
            'type' => ValueType::TYPE_BOOL,
            'region' => ValueType::REGION_GLOBAL,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => '',
                    'uk' => '',
                    'ru' => '',
                    'pl' => ''
                ]
            ]
        ],
        [
            'name' => 'menu_show_articles',
            'title' => 'Show articles in menu',
            'type' => ValueType::TYPE_BOOL,
            'region' => ValueType::REGION_GLOBAL,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => '',
                    'uk' => '',
                    'ru' => '',
                    'pl' => ''
                ]
            ]
        ],
        [
            'name' => 'menu_show_lyrics',
            'title' => 'Show lyrics in menu',
            'type' => ValueType::TYPE_BOOL,
            'region' => ValueType::REGION_GLOBAL,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => '',
                    'uk' => '',
                    'ru' => '',
                    'pl' => ''
                ]
            ]
        ],
        [
            'name' => 'header_flat_actions',
            'title' => 'Flat styles for icons of actions in header',
            'type' => ValueType::TYPE_BOOL,
            'region' => ValueType::REGION_GLOBAL,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => '',
                    'uk' => '',
                    'ru' => '',
                    'pl' => ''
                ]
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

        foreach (self::$valueTypes as $valueType) {
            $entity = new ValueType();
            $entity->setName($valueType['name']);
            $entity->setTitle($valueType['title']);
            $entity->setType($valueType['type']);
            $entity->setRegion($valueType['region']);
            $entity->setPriority($valueType['priority']);
            $entity->setEnabled($valueType['enabled']);
            $entity->setCreated($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('value_type-'.$valueType['name'], $entity);

            $manager->flush();

            /** @var array $translations */
            $translations = $valueType['translations'] ?? null;
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
