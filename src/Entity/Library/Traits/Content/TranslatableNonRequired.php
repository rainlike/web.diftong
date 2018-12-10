<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Content;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TranslatableNonRequired
 *
 * @package App\Entity\Library\Traits\Content
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait TranslatableNonRequired
{
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="content", type="text", length=5000, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 5000,
     *      maxMessage = "Content should be no longer than {{ limit }} characters."
     * )
     */
    private $content;

    /**
     * Set content
     *
     * @param string|null $content
     * @return self
     */
    public function setContent(?string $content = null): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
}
