<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Uri;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Unique
 *
 * @package App\Entity\Library\Traits\Uri
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Unique
{
    /**
     * @var string
     * @ORM\Column(name="uri", type="string", length=255, nullable=true, unique=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "URI should be no longer than {{ limit }} characters."
     * )
     */
    private $uri;

    /**
     * Set URI
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
