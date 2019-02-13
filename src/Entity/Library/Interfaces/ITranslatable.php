<?php
declare(strict_types=1);

namespace App\Entity\Library\Interfaces;

use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\Traits\Locale\Translatable;

/**
 * Interface ITranslatable
 *
 * @package App\Entity\Library\Interfaces
 * @author Alexander Saveliev <me@rainlike.com>
 */
interface ITranslatable extends IBasic
{
    /**
     * Add translations
     *
     * @param ITranslation $translation
     * @return Translatable|self
     */
    public function addTranslation(ITranslation $translation);

    /**
     * Remove translations
     *
     * @param ITranslation $translation
     * @return void
     */
    public function removeTranslation(ITranslation $translation): void;

    /**
     * Get translations
     *
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getTranslations();

    /**
     * Set translatable locale
     *
     * @param $locale
     * @return Translatable|self
     */
    public function setTranslatableLocale($locale);
}
