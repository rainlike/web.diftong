<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\IBasic;

use App\Entity\Library\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Library\Traits\Name\RequiredUnique as NameField;
use App\Entity\Library\Traits\Content\Required as ContentField;

/**
 * Class Lyric
 * Contains text of songs
 *
 * @package App\Entity
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_lyric")
 * @ORM\Entity(repositoryClass="App\Repository\LyricRepository")
 */
class Lyric extends BasicEntity implements IBasic
{
    use NameField;
    use ContentField;
    use UriField;

    /**
     * @var string
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
     * @var MusicAlbum
     * @ORM\ManyToOne(targetEntity="MusicAlbum", inversedBy="lyrics")
     * @ORM\JoinColumn(name="album", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Album should not be blank."
     * )
     */
    private $album;

    /**
     * @var Singer
     * @ORM\ManyToOne(targetEntity="Singer", inversedBy="lyrics")
     * @ORM\JoinColumn(name="singer", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Singer should not be blank."
     * )
     */
    private $singer;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Language", inversedBy="lyrics")
     * @ORM\JoinTable(name="app_lyrics_languages")
     */
    private $languages;

    /**
     * Lyric constructor
     */
    public function __construct()
    {
        $this->languages = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
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
     * Set album
     *
     * @param MusicAlbum $album
     * @return self
     */
    public function setAlbum(MusicAlbum $album): self
    {
        $this->album = $album;
        $album->addLyric($this);

        return $this;
    }

    /**
     * Get album
     *
     * @return MusicAlbum|null
     */
    public function getAlbum(): ?MusicAlbum
    {
        return $this->album;
    }

    /**
     * Set singer
     *
     * @param Singer $singer
     * @return self
     */
    public function setSinger(Singer $singer): self
    {
        $this->singer = $singer;
        $singer->addLyric($this);

        return $this;
    }

    /**
     * Get singer
     *
     * @return Singer|null
     */
    public function getSinger(): ?Singer
    {
        return $this->singer;
    }

    /**
     * Add language
     *
     * @param Language $language
     * @return self
     */
    public function addLanguage(Language $language): self
    {
        $this->languages[] = $language;

        return $this;
    }

    /**
     * Remove language
     *
     * @param Language $language
     * @return void
     */
    public function removeLanguage(Language $language): void
    {
        $this->languages->removeElement($language);
    }

    /**
     * Get languages
     *
     * @return ArrayCollection|null
     */
    public function getLanguages(): ?ArrayCollection
    {
        return $this->languages;
    }

    /**
     * Get first language
     *
     * @return Language|null
     */
    public function getLanguage(): ?Language
    {
        return \count($this->languages) > 0
            ? $this->languages[0]
            : null;
    }
}
