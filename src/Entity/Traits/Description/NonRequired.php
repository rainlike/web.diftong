<?php
declare(strict_types=1);

namespace App\Entity\Traits\Description;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait NonRequired
 *
 * @package App\Entity\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait NonRequired
{
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text", nullable=true, unique=false)
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "Description should be no longer than {{ limit }} characters."
     * )
     */
    private $description;

    /**
     * Set description
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
