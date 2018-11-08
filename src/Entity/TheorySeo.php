<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\Interfaces\Seoful;

use App\Entity\Translations\TheorySeoTranslation;

use App\Entity\Library\Seo;

use App\Entity\Library\Traits\Id as IdField;

/**
 * Class TheorySeo
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_theory_seo")
 * @ORM\Entity(repositoryClass="App\Repository\TheorySeoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TheorySeo extends Seo
{
    use IdField;

    /**
     * @var Theory
     * @ORM\OneToOne(targetEntity="Theory", inversedBy="seo")
     * @ORM\JoinColumn(name="target", referencedColumnName="id")
     */
    private $target;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\TheorySeoTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * TheorySeo constructor
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set target
     *
     * @param Seoful $target
     * @return self
     */
    public function setTarget(Seoful $target): self
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Set target
     *
     * @return Theory|null
     */
    public function getTarget(): ?Theory
    {
        return $this->target;
    }

    /**
     * Add translations
     *
     * @param TheorySeoTranslation $translation
     * @return self
     */
    public function addTranslation(TheorySeoTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param TheorySeoTranslation $translation
     * @return void
     */
    public function removeTranslation(TheorySeoTranslation $translation): void
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Get translations
     *
     * @return ArrayCollection|null
     */
    public function getTranslations(): ?ArrayCollection
    {
        return $this->translations;
    }
}
