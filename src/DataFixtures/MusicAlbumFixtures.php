<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\MusicAlbum;

/**
 * Class MusicAlbumFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class MusicAlbumFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset music albums
     * @var array
     */
    private static $albums = [
        [
            'name' => 'Sgt. Pepper\'s Lonely Hearts Club Band',
            'uri' => 'sgt-peppers-lonely-hearts-club-band',
            'singer' => 'the-beatles',
            'year' => 1967
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

        foreach (self::$albums as $album) {
            $entity = new MusicAlbum();
            $entity->setName($album['name']);
            $entity->setUri($album['uri']);
            $entity->setYear($album['year']);

            $entity->setSinger($this->getReference('singer-'.\strtolower($album['singer'])));

            $entity->setEnabled(true);
            $entity->setCreated($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('music_album-'.\str_replace('_', '-', $album['uri']), $entity);
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
        return 2;
    }
}
