<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Content;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Required
 *
 * @package App\Entity\Library\Traits\Content
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Required
{
    /**
     * @var string
     * @ORM\Column(name="content", type="text", length=5000, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="Content should not be blank."
     * )
     * @Assert\Length(
     *      max = 5000,
     *      maxMessage = "Content should be no longer than {{ limit }} characters."
     * )
     */
    private $content;

    /**
     * Set content
     *
     * @param string $content
     * @return self
     */
    public function setContent(string $content): self
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
