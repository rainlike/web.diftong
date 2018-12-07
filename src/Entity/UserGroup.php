<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\UserBundle\Model\Group as BaseGroup;

/**
 * Class UserGroup
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_user_group")
 * @ORM\Entity(repositoryClass="App\Repository\UserGroupRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class UserGroup extends BaseGroup
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    private $users;

    /**
     * UserGroup constructor
     *
     * @param string $name
     * @param array $roles
     */
    public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles);

        $this->users = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Add user
     *
     * @param User $user
     * @return self
     */
    public function addUser(User $user): self
    {
        $user->addGroup($this);
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param User $user
     * @return void
     */
    public function removeUser(User $user): void
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return ArrayCollection|null
     */
    public function getUsers(): ?ArrayCollection
    {
        return $this->users;
    }
}
