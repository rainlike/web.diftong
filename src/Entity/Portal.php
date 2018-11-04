<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Translations\PortalTranslation;

use App\Entity\Traits\Id as IdField;
use App\Entity\Traits\Locale as LocaleField;
use App\Entity\Traits\Enabled as EnabledField;
use App\Entity\Traits\Created as CreatedField;
use App\Entity\Traits\Updated as UpdatedField;
use App\Entity\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Traits\Title\Translatable as TitleField;
use App\Entity\Traits\Name\RequiredUnique as NameField;

/**
 * Class Portal
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_portal")
 * @ORM\Entity(repositoryClass="App\Repository\PortalRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\PortalTranslation")
 */
class Portal implements Translatable
{
    use IdField;
    use UriField;
    use NameField;
    use TitleField;
    use LocaleField;
    use EnabledField;
    use CreatedField;
    use UpdatedField;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\PortalTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set shortName
     *
     * @param string $shortName
     * @return self
     */
    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string|null
     */
    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    /**
     * Set articlePrefix
     *
     * @param string $articlePrefix
     * @return self
     */
    public function setArticlePrefix(string $articlePrefix): self
    {
        $this->articlePrefix = $articlePrefix;

        return $this;
    }

    /**
     * Get articlePrefix
     *
     * @return string|null
     */
    public function getArticlePrefix(): ?string
    {
        return $this->articlePrefix;
    }

    /**
     * Set URI
     *
     * @param string $uri
     * @return self
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get URI
     *
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
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
