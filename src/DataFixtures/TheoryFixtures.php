<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Seo;
use App\Entity\Theory;

use App\DataFixtures\Library\Traits\Mapping as MappingMethods;
use App\DataFixtures\Library\Traits\Translations as TranslationMethods;

/**
 * Class TheoryFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class TheoryFixtures extends Fixture implements OrderedFixtureInterface
{
    use MappingMethods;
    use TranslationMethods;

    /**
     * List of preset Theories
     * @var array
     */
    private static $theories = [
        'Grammar' => [
            [
                'index' => '1.grammar',
                'title' => 'Grammar',
                'full_title' => 'English grammar',
                'uri' => '/grammar',
                'is_general' => true,
                'content' => '@TODO',
                'formatted_content' => '<b>@TODO</b>',
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => null,
                'previous' => null,
                'next' => null,
                'translations' => [
                    'title' => [
                        'es' => 'Gramática',
                        'uk' => 'Граматика',
                        'ru' => 'Грамматика',
                        'pl' => 'Gramatyka'
                    ],
                    'full_title' => [
                        'es' => 'Gramatica inglesa',
                        'uk' => 'Граматика англійської мови',
                        'ru' => 'Грамматика английского языка',
                        'pl' => 'Gramatyka angielska'
                    ],
                    'content' => [],
                    'formatted_content' => []
                ]
            ],
            [
                'index' => '2.verb',
                'title' => 'Verb',
                'full_title' => null,
                'uri' => '/verb',
                'is_general' => false,
                'content' => '@TODO',
                'formatted_content' => '<b>@TODO</b>',
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'theory-1.grammar',
                'previous' => null,
                'next' => null,
                'translations' => [
                    'title' => [
                        'es' => 'Verbo',
                        'uk' => 'Дієслово',
                        'ru' => 'Глагол',
                        'pl' => 'Czasownik'
                    ],
                    'full_title' => [],
                    'content' => [],
                    'formatted_content' => []
                ],
                'seo' => [
                    'title' => 'Verb - title',
                    'description' => 'Verb - description',
                    'keywords' => 'Verb - keywords',
                    'translations' => [
                        'title' => [
                            'es' => 'Verbo - title',
                            'uk' => 'Дієслово - title',
                            'ru' => 'Глагол - title',
                            'pl' => 'Czasownik - title'
                        ],
                        'description' => [
                            'es' => 'Verbo - description',
                            'uk' => 'Дієслово - description',
                            'ru' => 'Глагол - description',
                            'pl' => 'Czasownik - description'
                        ],
                        'keywords' => [
                            'es' => 'Verbo - keywords',
                            'uk' => 'Дієслово - keywords',
                            'ru' => 'Глагол - keywords',
                            'pl' => 'Czasownik - keywords'
                        ],
                    ]
                ]
            ],
            [
                'index' => '3.verbs-personal-non-verbal',
                'title' => 'Personal and non-verbal forms of the verb',
                'full_title' => '@TODO',
                'uri' => '/verbs-personal-non-verbal',
                'is_general' => false,
                'content' => '@TODO',
                'formatted_content' => '<b>@TODO</b>',
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'theory-2.verb',
                'previous' => null,
                'next' => null,
                'translations' => [
                    'title' => [
                        'es' => 'Formas personales y no verbales del verbo',
                        'uk' => 'Особисті і неособисті форми дієслова',
                        'ru' => 'Личные и неличные формы глагола',
                        'pl' => 'Osobiste i niewerbalne formy czasownika'
                    ],
                    'full_title' => [],
                    'content' => [],
                    'formatted_content' => []
                ]
            ],
            [
                'index' => '2.noun',
                'title' => 'Noun',
                'full_title' => '@TODO',
                'uri' => '/noun',
                'is_general' => false,
                'content' => '@TODO',
                'formatted_content' => '<b>@TODO</b>',
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'theory-1.grammar',
                'previous' => 'theory-2.verb',
                'next' => null,
                'translations' => [
                    'title' => [
                        'es' => 'Sustantivo',
                        'uk' => 'Іменник',
                        'ru' => 'существительное',
                        'pl' => 'Rzeczownik'
                    ],
                    'full_title' => [],
                    'content' => [],
                    'formatted_content' => []
                ]
            ]
        ],
        'Pronounce' => [],
        'Vocabulary' => []
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

        foreach (self::$theories as $theoryList) {
            foreach ($theoryList as $theory) {
                $entity = new Theory();
                $entity->setTitle($theory['title']);
                $entity->setFullTitle($theory['full_title'] ?? null);
                $entity->setUri($theory['uri']);
                $entity->setIsGeneral($theory['is_general']);
                $entity->setContent($theory['content']);
                $entity->setFormattedContent($theory['formatted_content']);
                $entity->setEnabled($theory['enabled']);
                $entity->setCreated($now);
                $entity->setUpdated($now);
                $entity->setParent($theory['parent'] ? $this->getReference($theory['parent']) : null);
                $entity->setPrevious($theory['previous'] ? $this->getReference($theory['previous']) : null);
                $entity->setNext($theory['next'] ? $this->getReference($theory['next']) : null);

                $entity->setPortal($this->getReference($theory['portal']));

                $manager->persist($entity);

                $this->addReference('theory-'.$theory['index'], $entity);

                $manager->flush();

                /** @var array $translations */
                $translations = $theory['translations'] ?? null;
                if ($translations) {
                    $this->saveTranslations($translations, $entity, $manager);
                }

                /** @var array $seo */
                $seo = $theory['seo'] ?? null;
                if ($seo) {
                    $seoEntity = new Seo();
                    $seoEntity->setTitle($seo['title']);
                    $seoEntity->setDescription($seo['description']);
                    $seoEntity->setKeywords($seo['keywords']);
                    $seoEntity->setEnabled(true);
                    $seoEntity->setAutoGenerate(true);
                    $seoEntity->setCreated($now);
                    $seoEntity->setUpdated($now);
                    $seoEntity->setTarget($entity);

                    $manager->persist($seoEntity);
                    $manager->flush();

                    /** @var array $seoTranslations */
                    $seoTranslations = $seo['translations'] ?? null;
                    if ($seoTranslations) {
                        $this->saveTranslations($seoTranslations, $seoEntity, $manager);
                    }
                }
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
        return 2;
    }
}
