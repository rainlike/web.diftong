<?php
declare(strict_types=1);

namespace App\Entity\Traits\Title;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Required
 *
 * @package App\Entity\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Required
{
    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Title should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Title should be no longer than {{ limit }} characters."
     * )
     */
    private $title;

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
}
