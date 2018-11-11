<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Library\Basic;

use App\Entity\Translations\TopicTranslation;

use App\Entity\Library\Interfaces\ISlug;
use App\Entity\Library\Interfaces\ISeoful;

use App\Entity\Library\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Library\Traits\Content\Required as ContentField;
use App\Entity\Library\Traits\Locale\Translatable as LocaleField;
use App\Entity\Library\Traits\Title\TranslatableRequired as TitleField;
use App\Entity\Library\Traits\Title\FullTranslatableNonRequired as FullTitleField;

use App\Entity\Library\Traits\Slug\Required as SlugMethods;

/**
 * Class Topic
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_topic")
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\TopicTranslation")
 */
final class Topic extends Basic implements Translatable, ISeoful, ISlug
{
    use TitleField;
    use FullTitleField;
    use UriField;
    use ContentField;
    use LocaleField;

    use SlugMethods;

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
     * @var Portal
     * @ORM\ManyToOne(targetEntity="Portal", inversedBy="topics")
     * @ORM\JoinColumn(name="portal", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Portal should not be blank."
     * )
     */
    private $portal;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\TopicTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * Topic constructor
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
     * Set portal
     *
     * @param Portal $portal
     * @return self
     */
    public function setPortal(Portal $portal): self
    {
        $this->portal = $portal;
        $portal->addTopic($this);

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
     * @param TopicTranslation $translation
     * @return self
     */
    public function addTranslation(TopicTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param TopicTranslation $translation
     * @return void
     */
    public function removeTranslation(TopicTranslation $translation): void
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
