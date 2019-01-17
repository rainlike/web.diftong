<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\IBasic;

/**
 * Class Language
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_language")
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Language extends BasicEntity implements IBasic
{
    /**
     * @var string
     * @ORM\Column(name="locale", type="string", length=3, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "Locale should not be blank."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 3,
     *      minMessage = "Locale should be at least {{ limit }} characters long.",
     *      maxMessage = "Locale should be no longer than {{ limit }} characters."
     * )
     */
    private $locale;

    /**
     * @var string
     * @ORM\Column(name="icu", type="string", length=7, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "ICU should not be blank."
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 7,
     *      minMessage = "ICU should be at least {{ limit }} characters long.",
     *      maxMessage = "ICU should be no longer than {{ limit }} characters."
     * )
     */
    private $icu;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=50, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Name should not be blank."
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Name should be at least {{ limit }} characters long.",
     *      maxMessage = "Name should be no longer than {{ limit }} characters."
     * )
     */
    private $name;

    /**
     * @var Portal
     * @ORM\OneToOne(targetEntity="Portal", mappedBy="language")
     */
    private $portal;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Article", mappedBy="language")
     */
    private $articles;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Lyric", mappedBy="languages")
     */
    private $lyrics;

    /**
     * Language constructor
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->lyrics = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return self
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /**
     * Set icu
     *
     * @param string $icu
     * @return self
     */
    public function setIcu(string $icu): self
    {
        $this->icu = $icu;

        return $this;
    }

    /**
     * Get icu
     *
     * @return string|null
     */
    public function getIcu(): ?string
    {
        return $this->icu;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set portal
     *
     * @param Portal|null $portal
     * @return self
     */
    public function setPortal(?Portal $portal = null): self
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
     * Add lyric
     *
     * @param Lyric $lyric
     * @return self
     */
    public function addLyric(Lyric $lyric): self
    {
        $this->lyrics[] = $lyric;

        return $this;
    }

    /**
     * Remove lyric
     *
     * @param Lyric $lyric
     * @return void
     */
    public function removeLyric(Lyric $lyric): void
    {
        $this->lyrics->removeElement($lyric);
    }

    /**
     * Get lyrics
     *
     * @return ArrayCollection|null
     */
    public function getLyrics(): ?ArrayCollection
    {
        return $this->lyrics;
    }
}
