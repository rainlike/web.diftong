<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\UserRole;

/**
 * Class UserRoleFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class UserRoleFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset UserRoles
     * @var array
     */
    private static $roles = [
        [
            'name' => UserRole::ROLE_USER,
            'enabled' => true
        ],
        [
            'name' => UserRole::ROLE_ADMIN,
            'enabled' => true
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

        foreach (self::$roles as $role) {
            $entity = new UserRole();
            $entity->setName($role['name']);
            $entity->setEnabled($role['enabled']);
            $entity->setCreated($now);
            $entity->setUpdated($now);
            $manager->persist($entity);

            $this->addReference('user_role-'.\strtolower($role['name']), $entity);
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
