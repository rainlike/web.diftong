<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\UserBundle\Model\User as BaseUser;

use App\Entity\Library\Traits\Updated as UpdatedField;

/**
 * Class User
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * Mark of anonymous
     * @var string
     */
    public const USER_ANON = 'anon.';

    use UpdatedField;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="registered", type="datetime", nullable=false)
     * @Assert\NotBlank(
     *      message = "Registered date should not be blank."
     * )
     * @Assert\DateTime(
     *      message = "Registered date is not valid DateTime format."
     * )
     */
    private $registered;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserSetting", mappedBy="user")
     */
    private $settings;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="UserGroup", inversedBy="users")
     * @ORM\JoinTable(name="app_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="userId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="groupId", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * User constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->setRegistered(new \DateTime());
        $this->setUpdated(new \DateTime());

        $this->settings = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set registered
     *
     * @param \DateTime $registered
     * @return self
     */
    public function setRegistered(\DateTime $registered): self
    {
        $this->registered = $registered;

        return $this;
    }

    /**
     * Get registered
     *
     * @return \DateTime|null
     */
    public function getRegistered(): ?\DateTime
    {
        return $this->registered;
    }

    /**
     * Add setting
     *
     * @param UserSetting $setting
     * @return self
     */
    public function addSetting(UserSetting $setting): self
    {
        $this->settings[] = $setting;

        return $this;
    }

    /**
     * Remove setting
     *
     * @param UserSetting $setting
     * @return void
     */
    public function removeSetting(UserSetting $setting): void
    {
        $this->settings->removeElement($setting);
    }

    /**
     * Get settings
     *
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getSettings()
    {
        return $this->settings;
    }
}
