<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Caption;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait TranslatableRequired
 *
 * @package App\Entity\Library\Traits\Caption
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait TranslatableRequired
{
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="caption", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Caption should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Caption should be no longer than {{ limit }} characters."
     * )
     */
    private $caption;

    /**
     * Set caption
     *
     * @param string $caption
     * @return self
     */
    public function setCaption(string $caption): self
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }
}
