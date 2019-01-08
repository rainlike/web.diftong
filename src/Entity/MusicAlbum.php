<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\IBasic;

use App\Entity\Library\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Library\Traits\Title\RequiredUnique as NameField;

/**
 * Class MusicAlbum
 * Contains music album
 *
 * @package App\Entity
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_music_album")
 * @ORM\Entity(repositoryClass="App\Repository\MusicAlbumRepository")
 */
class MusicAlbum extends BasicEntity implements IBasic
{
    use NameField;
    use UriField;

    /**
     * @var int
     * @ORM\Column(name="year", type="integer", nullable=true, unique=false)
     * @Assert\Range(
     *      min = 1933,
     *      max = 2019,
     *      minMessage = "Year can not be earlier than {{ limit }}.",
     *      maxMessage = "Year should be no elder than {{ limit }}.",
     *      invalidMessage = "Year id should be a valid number."
     * )
     */
    private $year;

    /**
     * @var Singer
     * @ORM\ManyToOne(targetEntity="Singer", inversedBy="albums")
     * @ORM\JoinColumn(name="singer", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Singer should not be blank."
     * )
     */
    private $singer;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Lyric", mappedBy="album")
     */
    private $lyrics;

    /**
     * MusicAlbum constructor
     */
    public function __construct()
    {
        $this->lyrics = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set year
     *
     * @param int|null $year
     * @return self
     */
    public function setYear(?int $year = null): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
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
        $singer->addAlbum($this);

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
