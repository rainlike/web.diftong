<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\ISlug;
use App\Entity\Library\Interfaces\IBasic;
use App\Entity\Library\Interfaces\ISeoable;
use App\Entity\Library\Interfaces\ILastable;

use App\Entity\Library\Traits\Uri\Unique as UriField;
use App\Entity\Library\Traits\Title\Required as TitleField;
use App\Entity\Library\Traits\Content\Required as ContentField;

use App\Entity\Library\Traits\Slug\Required as SlugMethods;
use App\Entity\Library\Traits\UltimateUri as UltimateUriMethod;

use App\Entity\TopicTheme as Theme;

/**
 * Class Topic
 * Contains topics
 *
 * @package App\Entity
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_topic")
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 */
class Topic extends BasicEntity implements IBasic, ISeoable, ISlug, ILastable
{
    use TitleField;
    use UriField;
    use ContentField;

    use SlugMethods;
    use UltimateUriMethod;

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
     * @var Theme
     * @ORM\ManyToOne(targetEntity="TopicTheme", inversedBy="topics")
     * @ORM\JoinColumn(name="theme", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Theme should not be blank."
     * )
     */
    private $theme;

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
     * Set theme
     *
     * @param Theme $theme
     * @return self
     */
    public function setTheme(Theme $theme): self
    {
        $this->theme = $theme;
        $theme->addTopic($this);

        return $this;
    }

    /**
     * Get theme
     *
     * @return Theme|null
     */
    public function getTheme(): ?Theme
    {
        return $this->theme;
    }
}
