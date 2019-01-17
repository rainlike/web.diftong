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
use App\Entity\Library\Interfaces\ITranslatable;

use App\Entity\Library\Traits\Uri\Unique as UriField;
use App\Entity\Library\Traits\Locale\Translatable as LocaleField;

use App\Entity\Library\Traits\Caption\TranslatableRequired as CaptionField;
use App\Entity\Library\Traits\Preview\TranslatableRequired as PreviewField;
use App\Entity\Library\Traits\Title\TranslatableRequiredUnique as TitleField;
use App\Entity\Library\Traits\Description\TranslatableRequired as DescriptionField;

use App\Entity\Library\Traits\Slug\Required as SlugMethods;
use App\Entity\Library\Traits\Translations as TranslationMethods;

/**
 * Class Portal
 * Key entity of site, contains all relates Theory
 *
 * @package App\Entity
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_portal")
 * @ORM\Entity(repositoryClass="App\Repository\PortalRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\PortalTranslation")
 */
class Portal extends BasicEntity implements Translatable, IBasic, ISeoable, ITranslatable, ISlug
{
    use UriField;
    use TitleField;
    use CaptionField;
    use PreviewField;
    use DescriptionField;
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
     * @ORM\OneToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language", referencedColumnName="id")
     */
    private $language;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Theory", mappedBy="portal")
     */
    private $theories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Article", mappedBy="portal")
     */
    private $articles;

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
        $this->articles = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set language
     *
     * @param Language|null $language
     * @return self
     */
    public function setLanguage(?Language $language = null): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return Language|null
     */
    public function getLanguage(): ?Language
    {
        return $this->language;
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
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getTheories()
    {
        return $this->theories;
    }

    /**
     * Add article
     *
     * @param Article $article
     * @return self
     */
    public function addArticle(Article $article): self
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param Article $article
     * @return void
     */
    public function removeArticle(Article $article): void
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Add topic
     *
     * @param Topic $topic
     * @return self
     */
    public function addTopic(Topic $topic): self
    {
        $this->topics[] = $topic;

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
        $this->topics->removeElement($topic);
    }

    /**
     * Get topics
     *
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getTopics()
    {
        return $this->topics;
    }
}
