<?php
declare(strict_types=1);

namespace App\Entity;

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
     * @ORM\OneToMany(targetEntity="Category", mappedBy="portal")
     */
    private $categories;

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
        $this->categories = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Add category
     *
     * @param Category $category
     * @return self
     */
    public function addCategory(Category $category): self
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param Category $category
     * @return void
     */
    public function removeCategory(Category $category): void
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return ArrayCollection|null
     */
    public function getCategories(): ?ArrayCollection
    {
        return $this->categories;
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
