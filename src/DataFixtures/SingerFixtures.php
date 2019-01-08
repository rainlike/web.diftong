<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Singer;

use App\Service\Library;

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
    private static $singers = [];

    /**
     * Load fixtures
     *
     * @param ObjectManager
     * @return void
     * @throws \BadMethodCallException
     */
    public function load(ObjectManager $manager): void
    {
        // @TODO: ...
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
