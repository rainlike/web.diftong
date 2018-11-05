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
            [
                'title' => 'Grammar',
                'name' => 'grammar',
                'uri' => '/grammar',
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
            [
                'title' => 'Verb to be',
                'name' => 'verb-to-be',
                'uri' => '/verb-to-be',
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'category-grammar',
                'translations' => [
                    'es' => 'Verbo to be',
                    'uk' => 'Дієслово to be',
                    'ru' => 'Глагол to have',
                    'pl' => 'Czasownik to be'
                ]
            ],
            [
                'title' => 'Verb to have',
                'name' => 'verb-to-have',
                'uri' => '/verb-to-have',
                'enabled' => true,
                'portal' => 'portal-english',
                'parent' => 'category-grammar',
                'translations' => [
                    'es' => 'Verbo to have',
                    'uk' => 'Дієслово to have',
                    'ru' => 'Глагол to have',
                    'pl' => 'Czasownik to have'
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
                $entity->setName($category['name']);
                $entity->setUri($category['uri']);
                $entity->setEnabled($category['enabled']);
                $entity->setCreated($now);
                $entity->setUpdated($now);

                $entity->setPortal($this->getReference($category['portal']));

                if ($category['parent']) {
                    $entity->setParent($this->getReference($category['parent']));
                }

                $manager->persist($entity);

                $this->addReference('category-'.$category['name'], $entity);

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
