<?php
declare(strict_types=1);

namespace App\Entity\Traits\Name;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait Translatable
 *
 * @package App\Entity\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Translatable
{
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "Name should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Name should be no longer than {{ limit }} characters."
     * )
     */
    private $name;

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
}
