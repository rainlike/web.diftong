<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits;

use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\Interfaces\ITranslation;

/**
 * Trait Translations
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Translations
{
    /** @var ArrayCollection */
    private $translations;

    /**
     * Add translations
     *
     * @param ITranslation $translation
     * @return self
     */
    public function addTranslation(ITranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param ITranslation $translation
     * @return void
     */
    public function removeTranslation(ITranslation $translation): void
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Get translations
     *
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
