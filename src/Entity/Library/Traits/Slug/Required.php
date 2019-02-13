<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Slug;

/**
 * Trait Required
 *
 * @package App\Entity\Library\Traits\Slug
 * @author Alexander Saveliev <me@rainlike.com>
 */
trait Required
{
    /** @var string */
    private $slug;

    /**
     * Set slug
     *
     * @param string $slug
     * @return self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }
}
