<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\ISlug;
use App\Entity\Library\Interfaces\IBasic;
use App\Entity\Library\Interfaces\ISeoable;
use App\Entity\Library\Interfaces\ITranslatable;

use App\Entity\Library\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Library\Traits\Name\RequiredUnique as NameField;
use App\Entity\Library\Traits\Locale\Translatable as LocaleField;
use App\Entity\Library\Traits\Title\TranslatableRequiredUnique as TitleField;
use App\Entity\Library\Traits\Title\FullTranslatableNonRequired as FullTitleField;

use App\Entity\Library\Traits\Slug\Required as SlugMethods;
use App\Entity\Library\Traits\Translations as TranslationMethods;

/**
 * Class Portal
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_portal")
 * @ORM\Entity(repositoryClass="App\Repository\PortalRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\PortalTranslation")
 */
class Portal extends BasicEntity implements Translatable, IBasic, ISeoable, ITranslatable, ISlug
{
    use NameField;
    use TitleField;
    use FullTitleField;
    use UriField;
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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Theory", mappedBy="portal")
     */
    private $theories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Topic", mappedBy="portal")
     */
    private $topics;

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
        $this->topics = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
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
     * Add topic
     *
     * @param Topic $topic
     * @return self
     */
    public function addTopic(Topic $topic): self
    {
        $this->theories[] = $topic;

        return $this;
    }

    /**
     * Remove topic
     *
     * @param Topic $topic
     * @return void
     */
    public function removeTopic(Topic $topic): void
    {
        $this->theories->removeElement($topic);
    }

    /**
     * Get topics
     *
     * @return ArrayCollection|null
     */
    public function getTopics(): ?ArrayCollection
    {
        return $this->topics;
    }
}
