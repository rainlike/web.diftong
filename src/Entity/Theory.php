<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Library\Basic;

use App\Entity\Library\Interfaces\ISlug;
use App\Entity\Library\Interfaces\ISeoable;
use App\Entity\Library\Interfaces\ITranslatable;

use App\Entity\Library\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Library\Traits\Locale\Translatable as LocaleField;
use App\Entity\Library\Traits\Title\TranslatableRequired as TitleField;
use App\Entity\Library\Traits\Content\TranslatableRequired as ContentField;
use App\Entity\Library\Traits\Title\FullTranslatableNonRequired as FullTitleField;

use App\Entity\Library\Traits\Slug\Required as SlugMethods;
use App\Entity\Library\Traits\Translations as TranslationMethods;

/**
 * Class Theory
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_theory")
 * @ORM\Entity(repositoryClass="App\Repository\TheoryRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\TheoryTranslation")
 */
final class Theory extends Basic implements Translatable, ISeoable, ITranslatable, ISlug
{
    use TitleField;
    use FullTitleField;
    use UriField;
    use ContentField;
    use LocaleField;

    use SlugMethods;
    use TranslationMethods;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "Slug should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Slug should be no longer than {{ limit }} characters."
     * )
     */
    private $slug;

    /**
     * @var bool
     * @ORM\Column(name="is_general", type="boolean", nullable=true, unique=false)
     */
    private $isGeneral;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="formatted_content", type="text", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="Formatted content should not be blank."
     * )
     * @Assert\Length(
     *      max = 5000,
     *      maxMessage = "Formatted content should be no longer than {{ limit }} characters."
     * )
     */
    private $formattedContent;

    /**
     * @ORM\OneToOne(targetEntity="Theory")
     * @ORM\JoinColumn(name="previous_id", referencedColumnName="id", nullable=true, unique=false)
     */
    private $previous;

    /**
     * @ORM\OneToOne(targetEntity="Theory")
     * @ORM\JoinColumn(name="next_id", referencedColumnName="id", nullable=true, unique=false)
     */
    private $next;

    /**
     * @var Portal
     * @ORM\ManyToOne(targetEntity="Portal", inversedBy="theories")
     * @ORM\JoinColumn(name="portal", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Portal should not be blank."
     * )
     */
    private $portal;

    /**
     * @var Theory
     * @ORM\ManyToOne(targetEntity="Theory", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", nullable=true, unique=false)
     */
    private $parent;

    /**
     * @var Theory
     * @ORM\OneToMany(targetEntity="Theory", mappedBy="parent")
     */
    private $children;

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
     * Set formattedContent
     *
     * @param string $formattedContent
     * @return self
     */
    public function setFormattedContent(string $formattedContent): self
    {
        $this->formattedContent = $formattedContent;

        return $this;
    }

    /**
     * Get formattedContent
     *
     * @return string|null
     */
    public function getFormattedContent(): ?string
    {
        return $this->formattedContent;
    }

    /**
     * Set previous one
     *
     * @param self|null $previous
     * @return self
     */
    public function setPrevious(?Theory $previous = null): self
    {
        $this->previous = $previous;

        return $this;
    }

    /**
     * Get previous one
     *
     * @return self|null
     */
    public function getPrevious(): ?self
    {
        return $this->previous;
    }

    /**
     * Set next one
     *
     * @param self|null $next
     * @return self
     */
    public function setNext(?Theory $next = null): self
    {
        $this->next = $next;

        return $this;
    }

    /**
     * Get next one
     *
     * @return self|null
     */
    public function getNext(): ?self
    {
        return $this->next;
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
        $portal->addTheory($this);

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
    public function setParent(?Theory $parent = null): self
    {
        $this->parent = $parent;
        if ($parent) {
            $parent->addChild($this);
        }

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
    public function addChild(Theory $child): self
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
    public function removeChild(Theory $child): void
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
}
