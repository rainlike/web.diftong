<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait Locale
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Locale
{
    /**
     * @var string
     * @Gedmo\Locale
     */
    private $locale;

    /**
     * Set translatable locale
     *
     * @param $locale
     * @return self
     */
    public function setTranslatableLocale($locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
