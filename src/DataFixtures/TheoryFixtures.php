<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Theory;

/**
 * Class TheoryFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class TheoryFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset Theories
     * @var array
     */
    private static $theories = [
        'Grammar' => [
            [
                'index' => '1.grammar',
                'title' => 'Grammar',
                'full_title' => '@TODO',
                'uri' => '/grammar',
                'is_general' => true,
                'content' => '@TODO',
                'formatted_content' => '@TODO',
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
                    'full_title' => [],
                    'content' => [],
                    'formatted_content' => []
                ]
            ],
            [
                'index' => '2.verb',
                'title' => 'Verb',
                'full_title' => '@TODO',
                'uri' => '/verb',
                'is_general' => false,
                'content' => '@TODO',
                'formatted_content' => '@TODO',
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
                ]
            ],
            [
                'index' => '3.verbs-personal-non-verbal',
                'title' => 'Personal and non-verbal forms of the verb',
                'full_title' => '@TODO',
                'uri' => '/verbs-personal-non-verbal',
                'is_general' => false,
                'content' => '@TODO',
                'formatted_content' => '@TODO',
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
                'formatted_content' => '@TODO',
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
                $translations = $theory['translations'];
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
            'full_title' => 'fullTitle',
            'content' => 'content',
            'formatted_content' => 'formattedContent'
        ];

        return $mapping[$key] ?? null;
    }
}
