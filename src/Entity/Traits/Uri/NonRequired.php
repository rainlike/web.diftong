<?php
declare(strict_types=1);

namespace App\Entity\Traits\Uri;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="uri", type="string", length=255, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "URI should be no longer than {{ limit }} characters."
     * )
     */
    private $uri;

    /**
     * Get URI
     *
     * @param string|null $uri
     * @return self
     */
    public function setUri(?string $uri = null): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get URI
     *
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }
}
