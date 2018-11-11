<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Description;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait Required
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Required
{
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text", length=1000, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="Description should not be blank."
     * )
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "Description should be no longer than {{ limit }} characters."
     * )
     */
    private $description;

    /**
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
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
