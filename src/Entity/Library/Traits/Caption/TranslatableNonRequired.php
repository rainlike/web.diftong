<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Caption;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait TranslatableNonRequired
 *
 * @package App\Entity\Library\Traits\Caption
 * @author Alexander Saveliev <me@rainlike.com>
 */
trait TranslatableNonRequired
{
    /**
     * @var string
     *     * @Gedmo\Translatable
     * @ORM\Column(name="caption", type="string", length=255, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Caption should be no longer than {{ limit }} characters."
     * )
     */
    private $caption;

    /**
     * Set caption
     *
     * @param string|null $caption
     * @return self
     */
    public function setCaption(?string $caption = null): self
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
