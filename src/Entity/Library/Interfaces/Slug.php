<?php
declare(strict_types=1);

namespace App\Entity\Library\Interfaces;

/**
 * Interface Slug
 *
 * @package App\Entity\Library\Interfaces
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
interface Slug
{
    /**
     * Set target
     *
     * @param string $slug
     * @return self|mixed
     */
    public function setSlug(string $slug);

    /**
     * Get slug
     *
     * @return string|null
     */
    public function getSlug(): ?string;
}
