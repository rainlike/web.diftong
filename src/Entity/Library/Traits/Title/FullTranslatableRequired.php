<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Title;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait FullTranslatableRequired
 *
 * @package App\Entity\Library\Traits\Title
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait FullTranslatableRequired
{
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="full_title", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Full title should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Full title should be no longer than {{ limit }} characters."
     * )
     */
    private $fullTitle;

    /**
     * Set fullTitle
     *
     * @param string $fullTitle
     * @return self
     */
    public function setFullTitle(string $fullTitle): self
    {
        $this->fullTitle = $fullTitle;

        return $this;
    }

    /**
     * Get fullTitle
     *
     * @return string|null
     */
    public function getFullTitle(): ?string
    {
        return $this->fullTitle;
    }
}
