<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Url;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait RequiredUnique
 *
 * @package App\Entity\Library\Traits\Url
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait RequiredUnique
{
    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "URL should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "URL should be no longer than {{ limit }} characters."
     * )
     */
    private $url;

    /**
     * Set URL
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
     * Get URL
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
}
