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

use App\Entity\Library\Interfaces\IBasic;
use App\Entity\Library\Interfaces\ISeoable;
use App\Entity\Library\Interfaces\ITranslatable;

use App\Entity\Library\Traits\Locale\Translatable as LocaleField;
use App\Entity\Library\Traits\Title\TranslatableNonRequired as TitleField;
use App\Entity\Library\Traits\Description\TranslatableNonRequired as DescriptionField;

use App\Entity\Library\Traits\Translations as TranslationMethods;

/**
 * Class Seo
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_seo")
 * @ORM\Entity(repositoryClass="App\Repository\SeoRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\SeoTranslation")
 * @ORM\HasLifecycleCallbacks()
 */
class Seo extends BasicEntity implements Translatable, IBasic, ITranslatable
{
    use TitleField;
    use DescriptionField;
    use LocaleField;

    use TranslationMethods;

    /**
     * @var bool
     * @ORM\Column(name="auto_generate", type="boolean", nullable=true, unique=false)
     */
    private $autoGenerate;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="keywords", type="text", length=1000, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "Keywords should be no longer than {{ limit }} characters."
     * )
     */
    private $keywords;

    /**
     * @var int
     * @ORM\Column(name="target_id", type="integer", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="Target id should not be blank."
     * )
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "Target id can not be less than {{ limit }}%.",
     *      invalidMessage = "Target id should be a valid number."
     * )
     */
    private $targetId;

    /**
     * @var string
     * @ORM\Column(name="target_name", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Target name should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Target name should be no longer than {{ limit }} characters."
     * )
     */
    private $targetName;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\SeoTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * Seo constructor
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
     * Set autoGenerate
     *
     * @param bool $autoGenerate
     * @return self
     */
    public function setAutoGenerate(bool $autoGenerate = true): self
    {
        $this->autoGenerate = $autoGenerate;

        return $this;
    }

    /**
     * Get autoGenerate
     *
     * @return bool|null
     */
    public function getAutoGenerate(): ?bool
    {
        return $this->autoGenerate;
    }

    /**
     * Set keywords
     *
     * @param string|null $keywords
     * @return self
     */
    public function setKeywords(?string $keywords = null): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string|null
     */
    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    /**
     * Set targetId
     *
     * @param int $targetId
     * @return self
     */
    public function setTargetId(int $targetId): self
    {
        $this->targetId = $targetId;

        return $this;
    }

    /**
     * Get targetId
     *
     * @return int|null
     */
    public function getTargetId(): ?int
    {
        return $this->targetId;
    }

    /**
     * Set targetName
     *
     * @param string|null $targetName
     * @return self
     */
    public function setTargetName(string $targetName): self
    {
        $this->targetName = $targetName;

        return $this;
    }

    /**
     * Get targetName
     *
     * @return string|null
     */
    public function getTargetName(): ?string
    {
        return $this->targetName;
    }

    /**
     * Set target properties
     *
     * @param ISeoable $target
     * @return Seo
     */
    public function setTarget(ISeoable $target): self
    {
        $this->targetId = $target->getId();
        $this->targetName = $target->getClassName();

        return $this;
    }
}
