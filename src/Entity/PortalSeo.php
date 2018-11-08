<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\Interfaces\Seoful;

use App\Entity\Translations\PortalSeoTranslation;

use App\Entity\Library\Seo;

use App\Entity\Library\Traits\Id as IdField;

/**
 * Class PortalSeo
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_portal_seo")
 * @ORM\Entity(repositoryClass="App\Repository\PortalSeoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PortalSeo extends Seo
{
    use IdField;

    /**
     * @var Portal
     * @ORM\OneToOne(targetEntity="Portal", inversedBy="seo")
     * @ORM\JoinColumn(name="target", referencedColumnName="id")
     */
    private $target;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\PortalSeoTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * PortalSeo constructor
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
     * @return Portal|null
     */
    public function getTarget(): ?Portal
    {
        return $this->target;
    }

    /**
     * Add translations
     *
     * @param PortalSeoTranslation $translation
     * @return self
     */
    public function addTranslation(PortalSeoTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param PortalSeoTranslation $translation
     * @return void
     */
    public function removeTranslation(PortalSeoTranslation $translation): void
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
