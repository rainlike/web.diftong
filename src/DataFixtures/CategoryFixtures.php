<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Category;

/**
 * Class CategoryFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of Categories
     * @var array
     */
    private static $categories = [
        'Grammar' => [
            [ /** 1.Grammar **/
                'index' => '1.grammar',
                'title' => 'Grammar',
                'full_title' => '@TODO',
                'uri' => '/grammar',
                'is_general' => true,
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => null,
                'translations' => [
                    'title' => [
                        'es' => 'Gramática',
                        'uk' => 'Граматика',
                        'ru' => 'Грамматика',
                        'pl' => 'Gramatyka'
                    ],
                    'full_title' => []
                ]
            ],
            [ /** 2.Verb **/
                'index' => '2.verb',
                'title' => 'Verb',
                'full_title' => '@TODO',
                'uri' => '/verb',
                'is_general' => false,
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'category-1.grammar',
                'translations' => [
                    'title' => [
                        'es' => 'Verbo',
                        'uk' => 'Дієслово',
                        'ru' => 'Глагол',
                        'pl' => 'Czasownik'
                    ],
                    'full_title' => []
                ]
            ],
            [ /** 3.Personal and non-verbal forms of the verb **/
                'index' => '3.verbs-personal-non-verbal',
                'title' => 'Personal and non-verbal forms of the verb',
                'full_title' => '@TODO',
                'uri' => '/verbs-personal-non-verbal',
                'is_general' => false,
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'category-2.verb',
                'translations' => [
                    'title' => [
                        'es' => 'Formas personales y no verbales del verbo',
                        'uk' => 'Особисті і неособисті форми дієслова',
                        'ru' => 'Личные и неличные формы глагола',
                        'pl' => 'Osobiste i niewerbalne formy czasownika'
                    ],
                    'full_title' => []
                ]
            ],
            [ /** 2.Noun **/
                'index' => '1.noun',
                'title' => 'Noun',
                'full_title' => '@TODO',
                'uri' => '/noun',
                'is_general' => false,
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'category-1.grammar',
                'translations' => [
                    'title' => [
                        'es' => 'Sustantivo',
                        'uk' => 'Іменник',
                        'ru' => 'существительное',
                        'pl' => 'Rzeczownik'
                    ],
                    'full_title' => []
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

        foreach (self::$categories as $categoryList) {
            foreach ($categoryList as $category) {
                $entity = new Category();
                $entity->setTitle($category['title']);
                $entity->setFullTitle($category['full_title'] ?? null);
                $entity->setUri($category['uri']);
                $entity->setIsGeneral($category['is_general']);
                $entity->setEnabled($category['enabled']);
                $entity->setCreated($now);
                $entity->setUpdated($now);
                $entity->setParent($category['parent'] ? $this->getReference($category['parent']) : null);

                $entity->setPortal($this->getReference($category['portal']));

                $manager->persist($entity);

                $this->addReference('category-'.$category['index'], $entity);

                $manager->flush();

                /** @var array $translations */
                $translations = $category['translations'];
                foreach ($translations as $translationName => $targetTranslations) {
                    foreach ($targetTranslations as $locale => $translation) {
                        $setterName = $this->mapping($translationName);

                        if ($setterName) {
                            $setter = 'set'.\ucfirst($setterName);

                            $entity->setTranslatableLocale($locale);
                            $entity->$setter($translation);
                            $manager->persist($entity);
                            $manager->flush();
                        }
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

    /**
     * Get mapping
     *
     * @param string $key
     * @return string|null
     */
    private function mapping(string $key): ?string
    {
        $mapping = [
            'title' => 'title',
            'full_title' => 'fullTitle'
        ];

        return $mapping[$key] ?? null;
    }
}
