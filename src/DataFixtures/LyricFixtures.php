<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Lyric;

use App\Service\Library;

/**
 * Class LyricFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class LyricFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset lyrics
     * @var array
     */
    private static $lyrics = [
        [
            'name' => 'Lucy In The Sky With Diamonds',
            'uri' => 'lucy-in-the-sky-with-diamonds',
            'content' => 'Picture yourself in a boat on a river With tangerine trees and marmalade skies Somebody calls you, you answer quite slowly A girl with kaleidoscope eyes',
            'formatted_content' => 'Picture yourself in a boat on a river</br>
                With tangerine trees and marmalade skies</br>
                Somebody calls you, you answer quite slowly</br>
                A girl with kaleidoscope eyes
            ',
            'singer' => 'the-beatles',
            'album' => 'sgt-peppers-lonely-hearts-club-band',
            'languages' => ['en']
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

        foreach (self::$lyrics as $lyric) {
            $entity = new Lyric();
            $entity->setName($lyric['name']);
            $entity->setUri($lyric['uri']);
            $entity->setContent($lyric['content']);
            $entity->setFormattedContent($lyric['formatted_content']);

            $entity->setSinger($this->getReference('singer-'.\strtolower($lyric['singer'])));
            $entity->setAlbum($this->getReference('music_album-'.\strtolower($lyric['album'])));

            foreach ($lyric['languages'] as $language) {
                $entity->addLanguage($this->getReference('language-'.\strtolower($language)));
            }

            $entity->setEnabled(true);
            $entity->setCreated($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('lyric-'.\str_replace('_', '-', $lyric['uri']), $entity);
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
        return 3;
    }
}
