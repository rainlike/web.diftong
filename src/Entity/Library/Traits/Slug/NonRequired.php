<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Slug;

/**
 * Trait NonRequired
 *
 * @package App\Entity\Library\Traits\Slug
 * @author Alexander Saveliev <me@rainlike.com>
 */
trait NonRequired
{
    /**
     * Set slug
     *
     * @param string|null $slug
     * @return self
     */
    public function setSlug(?string $slug = null): self
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
