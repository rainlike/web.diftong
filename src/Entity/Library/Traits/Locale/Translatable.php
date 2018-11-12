<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Locale;

use Gedmo\Mapping\Annotation as Gedmo;

use App\Entity\Library\Interfaces\ITranslatable;

/**
 * Trait Translatable
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Translatable
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
