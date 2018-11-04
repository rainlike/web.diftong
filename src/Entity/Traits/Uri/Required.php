<?php
declare(strict_types=1);

namespace App\Entity\Traits\Uri;

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
     * @ORM\Column(name="uri", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "URI should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "URI should be no longer than {{ limit }} characters."
     * )
     */
    private $uri;

    /**
     * Get URI
     *
     * @param string $uri
     * @return self
     */
    public function setUri(string $uri): self
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
