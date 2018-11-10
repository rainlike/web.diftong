<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Seo;

use App\Entity\Library\Interfaces\Seo;

/**
 * Trait NonRequired
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait NonRequired
{
    /** @var Seo */
    private $seo;

    /**
     * Set SEO
     *
     * @param Seo|null $seo
     * @return self
     */
    public function setSeo(?Seo $seo = null): self
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get SEO
     *
     * @return Seo
     */
    public function getSeo()
    {
        return $this->seo;
    }
}
