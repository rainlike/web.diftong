<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\User;

/**
 * Class UserFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset Users
     * @var array
     */
    private static $users = [
        'alex' => [
            'email' => 'me@rainlike.com',
            'password' => 'alex',
            'roles' => [
                'ROLE_ADMIN'
            ],
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

        foreach (self::$users as $name => $data) {
            $entity = new User();
            $entity->setUsername($name);
            $entity->setEmail($data['email']);
            $entity->setPlainPassword($data['password']);
            $entity->setRoles($data['roles']);

            $entity->setEnabled($data['enabled']);
            $entity->setRegistered($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('user-'.$name, $entity);
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
