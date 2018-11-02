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
use App\Entity\Traits\Active as ActiveField;
use App\Entity\Traits\Locale as LocaleField;
use App\Entity\Traits\Created as CreatedField;
use App\Entity\Traits\Updated as UpdatedField;
use App\Entity\Traits\NameTranslatable as NameField;

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
    use NameField;
    use ActiveField;
    use LocaleField;
    use CreatedField;
    use UpdatedField;

    /**
     * @var string
     * @ORM\Column(name="short_name", type="string", length=32, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "Short name should not be blank."
     * )
     * @Assert\Length(
     *      max = 32,
     *      maxMessage = "Short name must be no longer than {{ limit }} characters."
     * )
     */
    private $shortName;

    /**
     * @var string
     * @ORM\Column(name="article_prefix", type="string", length=10, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "Article prefix should not be blank."
     * )
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Article prefix must be no longer than {{ limit }} characters."
     * )
     */
    private $articlePrefix;

    /**
     * @var string
     * @ORM\Column(name="url_prefix", type="string", length=32, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "URL prefix should not be blank."
     * )
     * @Assert\Length(
     *      max = 32,
     *      maxMessage = "URL prefix must be no longer than {{ limit }} characters."
     * )
     */
    private $urlPrefix;

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
     * Set urlPrefix
     *
     * @param string $urlPrefix
     * @return self
     */
    public function setUrlPrefix(string $urlPrefix): self
    {
        $this->urlPrefix = $urlPrefix;

        return $this;
    }

    /**
     * Get urlPrefix
     *
     * @return string|null
     */
    public function getUrlPrefix(): ?string
    {
        return $this->urlPrefix;
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
