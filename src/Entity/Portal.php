<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Translations\PortalTranslation;

use App\Entity\Library\Interfaces\Seoful;

use App\Entity\Library\Traits\Id as IdField;
use App\Entity\Library\Traits\Enabled as EnabledField;
use App\Entity\Library\Traits\Created as CreatedField;
use App\Entity\Library\Traits\Updated as UpdatedField;
use App\Entity\Library\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Library\Traits\Title\Translatable as TitleField;
use App\Entity\Library\Traits\Name\RequiredUnique as NameField;
use App\Entity\Library\Traits\Locale\Translatable as LocaleField;
use App\Entity\Library\Traits\Title\FullNonRequiredTranslatable as FullTitleField;

/**
 * Class Portal
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_portal")
 * @ORM\Entity(repositoryClass="App\Repository\PortalRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\PortalTranslation")
 */
class Portal implements Translatable, Seoful
{
    use IdField;
    use NameField;
    use TitleField;
    use FullTitleField;
    use UriField;
    use EnabledField;
    use CreatedField;
    use UpdatedField;
    use LocaleField;

    /**
     * @var PortalSeo
     * @ORM\OneToOne(targetEntity="PortalSeo", mappedBy="target")
     */
    private $seo;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Theory", mappedBy="portal")
     */
    private $theories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\PortalTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * Portal constructor
     */
    public function __construct()
    {
        $this->theories = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set SEO
     *
     * @param PortalSeo $seo
     * @return self
     */
    public function setSeo(?PortalSeo $seo = null): self
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get SEO
     *
     * @return PortalSeo
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * Add theory
     *
     * @param Theory $theory
     * @return self
     */
    public function addTheory(Theory $theory): self
    {
        $this->theories[] = $theory;

        return $this;
    }

    /**
     * Remove theory
     *
     * @param Theory $theory
     * @return void
     */
    public function removeTheory(Theory $theory): void
    {
        $this->theories->removeElement($theory);
    }

    /**
     * Get theories
     *
     * @return ArrayCollection|null
     */
    public function getTheories(): ?ArrayCollection
    {
        return $this->theories;
    }

    /**
     * Add translations
     *
     * @param PortalTranslation $translation
     * @return self
     */
    public function addTranslation(PortalTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param PortalTranslation $translation
     * @return void
     */
    public function removeTranslation(PortalTranslation $translation): void
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
