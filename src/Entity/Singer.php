<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\IBasic;

use App\Entity\Library\Traits\Uri\RequiredUnique as UriField;
use App\Entity\Library\Traits\Name\RequiredUnique as NameField;

/**
 * Class Singer
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_singer")
 * @ORM\Entity(repositoryClass="App\Repository\SingerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Singer extends BasicEntity implements IBasic
{
    use NameField;
    use UriField;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="MusicAlbum", mappedBy="singer")
     */
    private $albums;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Lyric", mappedBy="singer")
     */
    private $lyrics;

    /**
     * Singer constructor
     */
    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->lyrics = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Add album
     *
     * @param MusicAlbum $album
     * @return self
     */
    public function addAlbum(MusicAlbum $album): self
    {
        $this->albums[] = $album;

        return $this;
    }

    /**
     * Remove album
     *
     * @param MusicAlbum $album
     * @return void
     */
    public function removeAlbum(MusicAlbum $album): void
    {
        $this->lyrics->removeElement($album);
    }

    /**
     * Get albums
     *
     * @return ArrayCollection|null
     */
    public function getAlbums(): ?ArrayCollection
    {
        return $this->albums;
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
