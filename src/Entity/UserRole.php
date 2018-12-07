<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\IBasic;

/**
 * Class UserRole
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_user_role")
 * @ORM\Entity(repositoryClass="App\Repository\UserRoleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class UserRole extends BasicEntity implements IBasic
{
    /**
     * Possible roles for user
     * @var array
     */
    public const ROLES = [
        self::ROLE_USER,
        self::ROLE_ADMIN
    ];

    /**
     * Constants of possible roles for user
     * @var string
     */
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "Name should not be blank."
     * )
     * @Assert\Length(
     *      min = 6,
     *      max = 100,
     *      minMessage = "Name must be at least {{ limit }} characters long.",
     *      maxMessage = "Name must be no longer than {{ limit }} characters."
     * )
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="alias", type="string", length=255, nullable=true, unique=true)
     * @Assert\Length(
     *      min = 6,
     *      max = 100,
     *      minMessage = "Alias must be at least {{ limit }} characters long.",
     *      maxMessage = "Alias must be no longer than {{ limit }} characters."
     * )
     */
    private $alias;

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set alias
     *
     * @param string|null $alias
     * @return self
     */
    public function setAlias(?string $alias = null): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }
}
