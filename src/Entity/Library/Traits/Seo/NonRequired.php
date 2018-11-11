<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Seo;

use App\Entity\Library\Interfaces\ISeo;

/**
 * Trait NonRequired
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait NonRequired
{
    /** @var ISeo */
    private $seo;

    /**
     * Set SEO
     *
     * @param ISeo|null $seo
     * @return self
     */
    public function setSeo(?ISeo $seo = null): self
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get SEO
     *
     * @return ISeo
     */
    public function getSeo(): ISeo
    {
        return $this->seo;
    }
}
