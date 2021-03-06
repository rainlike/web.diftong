<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Name;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait NonRequired
 *
 * @package App\Entity\Library\Traits\Name
 * @author Alexander Saveliev <me@rainlike.com>
 */
trait NonRequired
{
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Name should be no longer than {{ limit }} characters."
     * )
     */
    private $name;

    /**
     * Set name
     *
     * @param string|null $name
     * @return self
     */
    public function setName(?string $name = null): self
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
}
