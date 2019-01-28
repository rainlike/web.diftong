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
            'section' => ValueType::SECTION_GLOBAL,
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
            'name' => 'header_logo_as_link',
            'title' => 'Header logo as link',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_HEADER,
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
            'name' => 'header_show_user_action',
            'title' => 'Show user action in header',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_HEADER,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar la acción del usuario en el encabezado.',
                    'uk' => 'Показувати кнопку користувача у верхній панелі',
                    'ru' => 'Показывать кнопку пользователя в верхней панели',
                    'pl' => 'Pokaż przycisk użytkownika na górnym pasku'
                ]
            ]
        ],
        [
            'name' => 'header_show_search_action',
            'title' => 'Show search action in header',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_HEADER,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar acción de búsqueda en el encabezado',
                    'uk' => 'Показувати кнопку пошуку у верхній панелі',
                    'ru' => 'Показывать кнопку поиска в верхней панели',
                    'pl' => 'Pokaż przycisk wyszukiwania na górnym pasku'
                ]
            ]
        ],
        [
            'name' => 'header_flat_actions',
            'title' => 'Flat styles for icons of actions in header',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_HEADER,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Estilos planos para iconos de acciones en cabecera',
                    'uk' => 'Плоскі стилі для іконок дій у верхній панелі',
                    'ru' => 'Плоские стили для иконок действий в верхней панели',
                    'pl' => 'Style płaskie dla ikon akcji na górnym pasku'
                ]
            ]
        ],
        [
            'name' => 'menu_show_grammar',
            'title' => 'Show grammar section in menu',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_MENU,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar sección de gramática en el menú',
                    'uk' => 'Показувати розділ граматики в меню',
                    'ru' => 'Показать раздел грамматики в меню',
                    'pl' => 'Pokaż sekcję gramatyki w menu'
                ]
            ]
        ],
        [
            'name' => 'menu_show_phonetics',
            'title' => 'Show phonetics section in menu',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_MENU,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar sección de fonética en el menú',
                    'uk' => 'Показати розділ фонетики в меню',
                    'ru' => 'Показать раздел фонетики в меню',
                    'pl' => 'Pokaż sekcję fonetyki w menu'
                ]
            ]
        ],
        [
            'name' => 'menu_show_lexis',
            'title' => 'Show lexis section in menu',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_MENU,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar sección de vocabulario en el menú',
                    'uk' => 'Показати розділ лексики в меню',
                    'ru' => 'Показать раздел лексики в меню',
                    'pl' => 'Pokaż sekcję leksykalną w menu'
                ]
            ]
        ],
        [
            'name' => 'menu_show_articles',
            'title' => 'Show articles in menu',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_MENU,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar articulos en menu',
                    'uk' => 'Показати статті в меню',
                    'ru' => 'Показать статьи в меню',
                    'pl' => 'Pokaż artykuły w menu'
                ]
            ]
        ],
        [
            'name' => 'menu_show_topics',
            'title' => 'Show topics in menu',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_MENU,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar las temas en menu',
                    'uk' => 'Показати топікі в меню',
                    'ru' => 'Показать топики в меню',
                    'pl' => 'Pokaż tematy w menu'
                ]
            ]
        ],
        [
            'name' => 'menu_show_lyrics',
            'title' => 'Show lyrics in menu',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_MENU,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar letras en el menú',
                    'uk' => 'Показати тексти пісень в меню',
                    'ru' => 'Показать тексты песен в меню',
                    'pl' => 'Pokaż teksty w menu'
                ]
            ]
        ],
        [
            'name' => 'theory_show_bottom_breadcrumbs',
            'title' => 'Show breadcrumbs at the bottom of theory page',
            'type' => ValueType::TYPE_BOOL,
            'section' => ValueType::SECTION_THEORY,
            'priority' => ValueType::PRIORITY_SITE,
            'enabled' => true,
            'translations' => [
                'title' => [
                    'es' => 'Mostrar las migas de pan en la parte inferior de la página de la teoría',
                    'uk' => 'Показати хлібні крихти внизу сторінки теорії',
                    'ru' => 'Показать хлебные крошки внизу страницы теории',
                    'pl' => 'Pokaż okruszki chleba na dole strony teorii'
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
            $entity->setSection($valueType['section']);
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
