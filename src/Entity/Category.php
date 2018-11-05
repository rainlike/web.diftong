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
use App\Entity\Traits\Enabled as EnabledField;
use App\Entity\Traits\Created as CreatedField;
use App\Entity\Traits\Updated as UpdatedField;
use App\Entity\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Traits\Title\Translatable as TitleField;
use App\Entity\Traits\Name\RequiredUnique as NameField;

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
    use NameField;
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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Theory", mappedBy="category")
     */
    private $theories;

    /**
     * @var Category
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var Portal
     * @ORM\ManyToOne(targetEntity="Portal", inversedBy="categories")
     * @ORM\JoinColumn(name="portal", referencedColumnName="id", nullable=false, unique=false)
     */
    private $portal;

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
     * Set portal
     *
     * @param Portal $portal
     * @return self
     */
    public function setPortal(Portal $portal): self
    {
        $this->portal = $portal;

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
