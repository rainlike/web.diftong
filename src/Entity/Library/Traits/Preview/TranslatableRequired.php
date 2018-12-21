<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Preview;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait TranslatableRequired
 *
 * @package App\Entity\Library\Traits\Preview
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait TranslatableRequired
{
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="preview", type="text", length=1000, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="Preview should not be blank."
     * )
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "Preview should be no longer than {{ limit }} characters."
     * )
     */
    private $preview;

    /**
     * Set preview
     *
     * @param string $preview
     * @return self
     */
    public function setPreview(string $preview): self
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * Get preview
     *
     * @return string|null
     */
    public function getPreview(): ?string
    {
        return $this->preview;
    }
}
