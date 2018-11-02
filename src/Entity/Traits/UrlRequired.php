<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait UrlRequired
 *
 * @package App\Entity\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait UrlRequired
{
    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "URL should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "URL must be no longer than {{ limit }} characters."
     * )
     */
    private $url;

    /**
     * Set url
     *
     * @param string $url
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
}
