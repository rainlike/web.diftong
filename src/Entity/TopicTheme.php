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
use App\Entity\Library\Traits\Title\TranslatableRequiredUnique as TitleField;
use App\Entity\Library\Traits\Description\TranslatableNonRequired as DescriptionField;

use App\Entity\Library\Traits\Slug\Required as SlugMethods;
use App\Entity\Library\Traits\UltimateUri as UltimateUriMethod;
use App\Entity\Library\Traits\Translations as TranslationMethods;

/**
 * Class TopicTheme
 * Contains topic's themes
 *
 * @package App\Entity
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_topic_theme")
 * @ORM\Entity(repositoryClass="App\Repository\TopicThemeRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\TopicThemeTranslation")
 */
class TopicTheme extends BasicEntity implements
    Translatable,
    IBasic,
    ISeoable,
    ITranslatable,
    ISlug,
    IUltimateUri
{
    use TitleField;
    use DescriptionField;
    use UriField;
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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Topic", mappedBy="theme")
     */
    private $topics;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\TopicThemeTranslation",
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
        $this->topics = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
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
