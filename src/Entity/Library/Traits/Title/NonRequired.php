<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Title;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait NonRequired
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait NonRequired
{
    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Title should be no longer than {{ limit }} characters."
     * )
     */
    private $title;

    /**
     * Set title
     *
     * @param string|null $title
     * @return self
     */
    public function setTitle(?string $title = null): self
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
