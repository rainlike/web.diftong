<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\IBasic;
use App\Entity\Library\Interfaces\ISetting;

use App\Entity\Library\Traits\Value\Required as ValueField;

/**
 * Class UserSetting
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_user_setting")
 * @ORM\Entity(repositoryClass="App\Repository\UserSettingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class UserSetting extends BasicEntity implements IBasic, ISetting
{
    use ValueField;

    /**
     * @var ValueType
     * @ORM\ManyToOne(targetEntity="ValueType", inversedBy="user_settings")
     * @ORM\JoinColumn(name="type", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Type should not be blank."
     * )
     */
    private $type;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="settings")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "User should not be blank."
     * )
     */
    private $user;

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set type
     *
     * @param ValueType $type
     * @return self
     */
    public function setType(ValueType $type): self
    {
        $this->type = $type;
        $type->addUserSetting($this);

        return $this;
    }

    /**
     * Get type
     *
     * @return ValueType|null
     */
    public function getType(): ?ValueType
    {
        return $this->type;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}
