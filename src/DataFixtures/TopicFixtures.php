<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Topic;

use App\Service\Library;

/**
 * Class TopicFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class TopicFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset topics
     * @var array
     */
    private static $topics = [
        [
            'title' => 'About me',
            'content' => 'My full name is Bushueva Valeria Dmitrievna. I was born in Moscow, Russia in 2002. I\'m 11 years old. About my appearance, I\'m tall and thin (probably), I have big blue eyes and blond hair. About my character, I am very friendly, but only with people that I think are quite good. I happen really impatient and curious, but I do not consider it a disadvantage. Do not know whether to write. I think I\'ve told everything about myself. I do not think my life is boring because every day confronted with something new and interesting for me. For example: meeting new people at school or a meeting with the best friends. That\'s all! Goodbye! B. V. D.',
            'theme' => 'my-life',
            'portal' => 'english',
            'uri' => 'about-me'
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

        foreach (self::$topics as $topic) {
            $entity = new Topic();
            $entity->setTitle($topic['title']);
            $entity->setContent($topic['content']);
            $entity->setUri($topic['uri']);
            $entity->setEnabled(true);
            $entity->setCreated($now);
            $entity->setUpdated($now);
            $entity->setTheme($this->getReference('topic-theme-'.$topic['theme']));
            $entity->setPortal($this->getReference('portal-'.$topic['portal']));

            $manager->persist($entity);

            $this->addReference('topic-'.Library::slug($topic['title']), $entity);

            $manager->flush();
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
