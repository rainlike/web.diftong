<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Translations\TheoryTranslation;

use App\Entity\Traits\Id as IdField;
use App\Entity\Traits\Locale as LocaleField;
use App\Entity\Traits\Enabled as EnabledField;
use App\Entity\Traits\Created as CreatedField;
use App\Entity\Traits\Updated as UpdatedField;
use App\Entity\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Traits\Title\Translatable as TitleField;
use App\Entity\Traits\Title\FullNonRequiredTranslatable as FullTitleField;

/**
 * Class Theory
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_theory")
 * @ORM\Entity(repositoryClass="App\Repository\TheoryRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\TheoryTranslation")
 */
class Theory implements Translatable
{
    use IdField;
    use UriField;
    use TitleField;
    use LocaleField;
    use EnabledField;
    use CreatedField;
    use UpdatedField;
    use FullTitleField;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="content", type="text", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="Content should not be blank."
     * )
     * @Assert\Length(
     *      max = 5000,
     *      maxMessage = "Content should be no longer than {{ limit }} characters."
     * )
     */
    private $content;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="html", type="text", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="HTML content should not be blank."
     * )
     * @Assert\Length(
     *      max = 5000,
     *      maxMessage = "HTML content should be no longer than {{ limit }} characters."
     * )
     */
    private $html;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="theories")
     * @ORM\JoinColumn(name="category", referencedColumnName="id", nullable=false, unique=false)
     */
    private $category;

    /**
     * @var Theory
     * @ORM\ManyToOne(targetEntity="Theory", inversedBy="relations")
     * @ORM\JoinColumn(name="referrer", referencedColumnName="id", nullable=true, unique=false)
     */
    private $referrer;

    /**
     * @var Theory
     * @ORM\OneToMany(targetEntity="Theory", mappedBy="referrer")
     */
    private $relations;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\TheoryTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * Theory constructor
     */
    public function __construct()
    {
        $this->relations = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set content
     *
     * @param string $content
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set HTML
     *
     * @param string $html
     * @return self
     */
    public function setHtml(string $html): self
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get HTML
     *
     * @return string|null
     */
    public function getHtml(): ?string
    {
        return $this->html;
    }

    /**
     * Set category
     *
     * @param Category $category
     * @return self
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;
        $category->addTheory($this);

        return $this;
    }

    /**
     * Get category
     *
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Set referrer
     *
     * @param self|null $referrer
     * @return self
     */
    public function setReferrer(?Theory $referrer = null): self
    {
        $this->referrer = $referrer;
        $referrer->addRelation($this);

        return $this;
    }

    /**
     * Get referrer
     *
     * @return self|null
     */
    public function getReferrer(): ?self
    {
        return $this->referrer;
    }

    /**
     * Add relation
     *
     * @param self $relation
     * @return self
     */
    public function addRelation(Theory $relation): self
    {
        $this->relations[] = $relation;

        return $this;
    }

    /**
     * Remove relation
     *
     * @param self $relation
     * @return void
     */
    public function removeRelation(Theory $relation): void
    {
        $this->relations->removeElement($relation);
    }

    /**
     * Get relations
     *
     * @return ArrayCollection|null
     */
    public function getRelations(): ?ArrayCollection
    {
        return $this->relations;
    }

    /**
     * Add translations
     *
     * @param TheoryTranslation $translation
     * @return self
     */
    public function addTranslation(TheoryTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param TheoryTranslation $translation
     * @return void
     */
    public function removeTranslation(TheoryTranslation $translation): void
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
