<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Quote;

/**
 * Class QuoteFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class QuoteFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset quotes
     * @var array
     */
    private static $quotes = [
        [
            'text' => 'I am fond of pigs. Dogs look up to us. Cats look down on us. Pigs treat us as equals.',
            'author' => 'Winston Churchill'
        ],
        [
            'text' => 'Once I get on a puzzle, I can\'t get off.',
            'author' => 'Richard Phillips Feynman'
        ],
        [
            'text' => 'On parle toujours mal quand on n\'a rien à dire.',
            'author' => 'Voltaire'
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

        foreach (self::$quotes as $quote) {
            $entity = new Quote();
            $entity->setText($quote['text']);
            $entity->setAuthor($quote['author']);
            $entity->setEnabled(true);
            $entity->setCreated($now);
            $entity->setUpdated($now);
            $manager->persist($entity);
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
