<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\ISlug;
use App\Entity\Library\Interfaces\IBasic;
use App\Entity\Library\Interfaces\ISeoable;
use App\Entity\Library\Interfaces\IUltimateUri;
use App\Entity\Library\Interfaces\ITranslatable;

use App\Entity\Library\Traits\Uri\Unique as UriField;
use App\Entity\Library\Traits\Locale\Translatable as LocaleField;
use App\Entity\Library\Traits\Content\TranslatableRequired as ContentField;
use App\Entity\Library\Traits\Caption\TranslatableRequired as CaptionField;
use App\Entity\Library\Traits\Title\TranslatableRequiredUnique as TitleField;

use App\Entity\Library\Traits\Slug\Required as SlugMethods;
use App\Entity\Library\Traits\UltimateUri as UltimateUriMethod;
use App\Entity\Library\Traits\Translations as TranslationMethods;

/**
 * Class Theory
 * Contains separate info for Portals
 *
 * @package App\Entity
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_theory")
 * @ORM\Entity(repositoryClass="App\Repository\TheoryRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\TheoryTranslation")
 */
class Theory extends BasicEntity implements
    Translatable,
    IBasic,
    ISeoable,
    ITranslatable,
    ISlug,
    IUltimateUri
{
    use TitleField;
    use CaptionField;
    use UriField;
    use ContentField;
    use LocaleField;

    use SlugMethods;
    use UltimateUriMethod;
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
     * @ORM\Column(name="general", type="boolean", nullable=true, unique=false)
     */
    private $general;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="formatted_content", type="text", length=5000, nullable=false, unique=false)
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
     * @ORM\OneToOne(targetEntity="Theory", fetch="LAZY")
     * @ORM\JoinColumn(name="previous_id", referencedColumnName="id", nullable=true, unique=false)
     */
    private $previous;

    /**
     * @ORM\OneToOne(targetEntity="Theory", fetch="LAZY")
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
     * Set general
     *
     * @param bool $general
     * @return self
     */
    public function setGeneral(bool $general = true): self
    {
        $this->general = $general;

        return $this;
    }

    /**
     * Get general
     *
     * @return bool|null
     */
    public function getGeneral(): ?bool
    {
        return $this->general;
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
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Check if theory is pre-general
     *
     * @return bool
     */
    public function isPreGeneral(): bool
    {
        $parent = $this->getParent();

        return $parent && $parent->getGeneral();
    }
}
