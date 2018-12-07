<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\SiteSetting;

/**
 * Class SiteSettingFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class SiteSettingFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset SiteSettings
     * @var array
     */
    private static $settings = [
        [
            'type' => 'global_show_topbar',
            'value' => 1
        ],
        [
            'type' => 'global_logo_as_link',
            'value' => 1
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

        foreach (self::$settings as $setting) {
            $entity = new SiteSetting();
            $entity->setType($this->getReference('value_type-'.$setting['type']));
            $entity->setValue((string)$setting['value']);
            $entity->setEnabled(true);
            $entity->setCreated($now);
            $entity->setUpdated($now);
            $manager->persist($entity);

            $this->addReference('site_setting-'.$setting['type'], $entity);
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
