<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Url
 *
 * @package App\Entity\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Url
{
    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "URL must be no longer than {{ limit }} characters."
     * )
     */
    private $url;

    /**
     * Set url
     *
     * @param string|null $url
     * @return self
     */
    public function setUrl(?string $url = null): self
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
