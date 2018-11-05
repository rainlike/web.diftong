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
                'uri' => '/grammar',
                'is_general' => true,
                'personal_page' => true,
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => null,
                'translations' => [
                    'es' => 'Gramática',
                    'uk' => 'Граматика',
                    'ru' => 'Грамматика',
                    'pl' => 'Gramatyka'
                ]
            ],
            [ /** 2.Verb **/
                'index' => '2.verb',
                'title' => 'Verb',
                'uri' => '/verb',
                'is_general' => false,
                'personal_page' => false,
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'category-1.grammar',
                'translations' => [
                    'es' => 'Verbo',
                    'uk' => 'Дієслово',
                    'ru' => 'Глагол',
                    'pl' => 'Czasownik'
                ]
            ],
            [ /** 3.Personal and non-verbal forms of the verb **/
                'index' => '3.verbs-personal-non-verbal',
                'title' => 'Personal and non-verbal forms of the verb',
                'uri' => '/verbs-personal-non-verbal',
                'is_general' => false,
                'personal_page' => false,
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'category-2.verb',
                'translations' => [
                    'es' => 'Formas personales y no verbales del verbo',
                    'uk' => 'Особисті і неособисті форми дієслова',
                    'ru' => 'Личные и неличные формы глагола',
                    'pl' => 'Osobiste i niewerbalne formy czasownika'
                ]
            ],
            [ /** 2.Noun **/
                'index' => '1.noun',
                'title' => 'Noun',
                'uri' => '/noun',
                'is_general' => false,
                'personal_page' => false,
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'category-1.grammar',
                'translations' => [
                    'es' => 'Sustantivo',
                    'uk' => 'Іменник',
                    'ru' => 'существительное',
                    'pl' => 'Rzeczownik'
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
                $entity->setIsGeneral($category['is_general']);
                $entity->setPersonalPage($category['personal_page']);
                $entity->setEnabled($category['enabled']);
                $entity->setCreated($now);
                $entity->setUpdated($now);

                if ($category['uri']) {
                    $entity->setUri($category['uri']);
                }

                $entity->setPortal($this->getReference($category['portal']));

                if ($category['parent']) {
                    $entity->setParent($this->getReference($category['parent']));
                }

                $manager->persist($entity);

                $this->addReference('category-'.$category['index'], $entity);

                $manager->flush();

                /** @var array $translations */
                $translations = $category['translations'];
                foreach ($translations as $locale => $translation) {
                    $entity->setTranslatableLocale($locale);
                    $entity->setTitle($translation);
                    $manager->persist($entity);
                    $manager->flush();
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
