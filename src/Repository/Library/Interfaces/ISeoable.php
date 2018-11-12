<?php
declare(strict_types=1);

namespace App\Repository\Library\Interfaces;

use App\Entity\Seo;

use App\Entity\Library\Interfaces\ISeoable as ISeoableEntity;

/**
 * Interface ISeoable
 *
 * @package App\Repository\Library\Interfaces
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
interface ISeoable
{
    /**
     * Get SEO
     *
     * @param ISeoableEntity $target
     * @return Seo|null
     */
    public function getSeo(ISeoableEntity $target): ?Seo;
}
