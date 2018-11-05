<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Translations\CategoryTranslation;

use App\Entity\Traits\Id as IdField;
use App\Entity\Traits\Locale as LocaleField;
use App\Entity\Traits\Uri\Unique as UriField;
use App\Entity\Traits\Enabled as EnabledField;
use App\Entity\Traits\Created as CreatedField;
use App\Entity\Traits\Updated as UpdatedField;
use App\Entity\Traits\Title\Translatable as TitleField;

/**
 * Class Category
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_category")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\CategoryTranslation")
 */
class Category implements Translatable
{
    use IdField;
    use UriField;
    use TitleField;
    use LocaleField;
    use EnabledField;
    use CreatedField;
    use UpdatedField;

    /**
     * @var bool
     * @ORM\Column(name="is_general", type="boolean", nullable=true, unique=false)
     */
    private $isGeneral;

    /**
     * @var bool
     * @ORM\Column(name="personal_page", type="boolean", nullable=true, unique=false)
     */
    private $personalPage;

    /**
     * @var Portal
     * @ORM\ManyToOne(targetEntity="Portal", inversedBy="categories")
     * @ORM\JoinColumn(name="portal", referencedColumnName="id", nullable=false, unique=false)
     */
    private $portal;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", nullable=true, unique=false)
     */
    private $parent;

    /**
     * @var Category
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Theory", mappedBy="category")
     */
    private $theories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\CategoryTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * Category constructor
     */
    public function __construct()
    {
        $this->theories = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set isGeneral
     *
     * @param bool $isGeneral
     * @return self
     */
    public function setIsGeneral(bool $isGeneral = true): self
    {
        $this->isGeneral = $isGeneral;

        return $this;
    }

    /**
     * Get isGeneral
     *
     * @return bool|null
     */
    public function getIsGeneral(): ?bool
    {
        return $this->isGeneral;
    }

    /**
     * Set personalPage
     *
     * @param bool $personalPage
     * @return self
     */
    public function setPersonalPage(bool $personalPage = true): self
    {
        $this->personalPage = $personalPage;

        return $this;
    }

    /**
     * Get personalPage
     *
     * @return bool|null
     */
    public function getPersonalPage(): ?bool
    {
        return $this->personalPage;
    }

    /**
     * Set portal
     *
     * @param Portal $portal
     * @return self
     */
    public function setPortal(Portal $portal): self
    {
        $this->portal = $portal;
        $portal->addCategory($this);

        return $this;
    }

    /**
     * Get portal
     *
     * @return Portal|null
     */
    public function getPortal(): ?Portal
    {
        return $this->portal;
    }

    /**
     * Set parent
     *
     * @param self|null $parent
     * @return self
     */
    public function setParent(?Category $parent = null): self
    {
        $this->parent = $parent;
        $parent->addChild($this);

        return $this;
    }

    /**
     * Get parent
     *
     * @return self|null
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param self $child
     * @return self
     */
    public function addChild(Category $child): self
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param self $child
     * @return void
     */
    public function removeChild(Category $child): void
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return ArrayCollection|null
     */
    public function getChildren(): ?ArrayCollection
    {
        return $this->children;
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
     * @param CategoryTranslation $translation
     * @return self
     */
    public function addTranslation(CategoryTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param CategoryTranslation $translation
     * @return void
     */
    public function removeTranslation(CategoryTranslation $translation): void
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
