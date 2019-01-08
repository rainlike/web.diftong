<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Singer;

/**
 * Class SingerFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class SingerFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset singers
     * @var array
     */
    private static $singers = [
        [
            'name' => 'the Beatles',
            'uri' => 'the-beatles'
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

        foreach (self::$singers as $singer) {
            $entity = new Singer();
            $entity->setName($singer['name']);
            $entity->setUri($singer['uri']);

            $entity->setEnabled(true);
            $entity->setCreated($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('singer-'.\str_replace('_', '-', $singer['uri']), $entity);
        }

        $manager->flush();
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
