<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Seo;

use App\Entity\Library\Interfaces\Seo;

/**
 * Trait Required
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Required
{
    /** @var Seo */
    private $seo;

    /**
     * Set SEO
     *
     * @param Seo $seo
     * @return self
     */
    public function setSeo(Seo $seo): self
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
