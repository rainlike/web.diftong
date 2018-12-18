<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Seo;
use App\Entity\Theory;

use App\DataFixtures\Library\Traits\Translations as TranslationMethods;

/**
 * Class TheoryFixtures
 * Fixtures for Theories
 *
 * @package App\DataFixtures
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class TheoryFixtures extends Fixture implements OrderedFixtureInterface
{
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
                'caption' => 'English grammar',
                'uri' => 'grammar',
                'is_general' => true,
                'content' => '@CONTENT',
                'formatted_content' => '<b>@FORMATTED_CONTENT</b>',
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
                    'caption' => [
                        'es' => '@CAPTION (es)',
                        'uk' => '@CAPTION (uk)',
                        'ru' => '@CAPTION (ru)',
                        'pl' => '@CAPTION (pl)'
                    ],
                    'content' => [
                        'es' => '@CONTENT (es)',
                        'uk' => '@CONTENT (uk)',
                        'ru' => '@CONTENT (ru)',
                        'pl' => '@CONTENT (pl)'
                    ],
                    'formatted_content' => [
                        'es' => '@FORMATTED_CONTENT (es)',
                        'uk' => '@FORMATTED_CONTENT (uk)',
                        'ru' => '@FORMATTED_CONTENT (ru)',
                        'pl' => '@FORMATTED_CONTENT (pl)'
                    ]
                ]
            ],
            [
                'index' => '2.verb',
                'title' => 'Verb',
                'caption' => 'English verb',
                'uri' => 'verb',
                'is_general' => false,
                'content' => '@CONTENT',
                'formatted_content' => '<b>@FORMATTED_CONTENT</b>',
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
                    'caption' => [
                        'es' => '@CAPTION (es)',
                        'uk' => '@CAPTION (uk)',
                        'ru' => '@CAPTION (ru)',
                        'pl' => '@CAPTION (pl)'
                    ],
                    'content' => [
                        'es' => '@CONTENT (es)',
                        'uk' => '@CONTENT (uk)',
                        'ru' => '@CONTENT (ru)',
                        'pl' => '@CONTENT (pl)'
                    ],
                    'formatted_content' => [
                        'es' => '@FORMATTED_CONTENT (es)',
                        'uk' => '@FORMATTED_CONTENT (uk)',
                        'ru' => '@FORMATTED_CONTENT (ru)',
                        'pl' => '@FORMATTED_CONTENT (pl)'
                    ]
                ],
                'seo' => [
                    'title' => '@TITLE',
                    'description' => '@DESCRIPTION',
                    'keywords' => '@KEYWORDS',
                    'translations' => [
                        'title' => [
                            'es' => '@TITLE (es)',
                            'uk' => '@TITLE (uk)',
                            'ru' => '@TITLE (ru)',
                            'pl' => '@TITLE (pl)'
                        ],
                        'description' => [
                            'es' => '@DESCRIPTION (es)',
                            'uk' => '@DESCRIPTION (uk)',
                            'ru' => '@DESCRIPTION (ru)',
                            'pl' => '@DESCRIPTION (pl)'
                        ],
                        'keywords' => [
                            'es' => '@KEYWORDS (es)',
                            'uk' => '@KEYWORDS (uk)',
                            'ru' => '@KEYWORDS (ru)',
                            'pl' => '@KEYWORDS (pl)'
                        ],
                    ]
                ]
            ],
            [
                'index' => '3.verbs-personal-non-verbal',
                'title' => 'Personal and non-verbal forms of the verb',
                'caption' => '@CAPTION',
                'uri' => 'verbs-personal-non-verbal',
                'is_general' => false,
                'content' => '@CONTENT',
                'formatted_content' => '<b>@FORMATTED_CONTENT</b>',
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
                    'caption' => [
                        'es' => '@CAPTION (es)',
                        'uk' => '@CAPTION (uk)',
                        'ru' => '@CAPTION (ru)',
                        'pl' => '@CAPTION (pl)'
                    ],
                    'content' => [
                        'es' => '@CONTENT (es)',
                        'uk' => '@CONTENT (uk)',
                        'ru' => '@CONTENT (ru)',
                        'pl' => '@CONTENT (pl)'
                    ],
                    'formatted_content' => [
                        'es' => '@FORMATTED_CONTENT (es)',
                        'uk' => '@FORMATTED_CONTENT (uk)',
                        'ru' => '@FORMATTED_CONTENT (ru)',
                        'pl' => '@FORMATTED_CONTENT (pl)'
                    ]
                ]
            ],
            [
                'index' => '2.noun',
                'title' => 'Noun',
                'caption' => '@CAPTION',
                'uri' => 'noun',
                'is_general' => false,
                'content' => '@CONTENT',
                'formatted_content' => '<b>@FORMATTED_CONTENT</b>',
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
                    'caption' => [
                        'es' => '@CAPTION (es)',
                        'uk' => '@CAPTION (uk)',
                        'ru' => '@CAPTION (ru)',
                        'pl' => '@CAPTION (pl)'
                    ],
                    'content' => [
                        'es' => '@CONTENT (es)',
                        'uk' => '@CONTENT (uk)',
                        'ru' => '@CONTENT (ru)',
                        'pl' => '@CONTENT (pl)'
                    ],
                    'formatted_content' => [
                        'es' => '@FORMATTED_CONTENT (es)',
                        'uk' => '@FORMATTED_CONTENT (uk)',
                        'ru' => '@FORMATTED_CONTENT (ru)',
                        'pl' => '@FORMATTED_CONTENT (pl)'
                    ]
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
                $entity->setCaption($theory['caption']);
                $entity->setUri($theory['uri'] ?? null);
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
