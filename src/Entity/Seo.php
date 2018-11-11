<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Library\Basic;

use App\Entity\Translations\SeoTranslation;

use App\Entity\Library\Traits\Locale\Translatable as LocaleField;
use App\Entity\Library\Traits\Title\TranslatableNonRequired as TitleField;
use App\Entity\Library\Traits\Description\TranslatableNonRequired as DescriptionField;

/**
 * Class Seo
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_seo")
 * @ORM\Entity(repositoryClass="App\Repository\SeoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
final class Seo extends Basic implements Translatable
{
    /** @var string */
    public const TARGET_CLASS_PREFIX = 'App.Entity'; // @TODO: rename to correct

    use TitleField;
    use DescriptionField;
    use LocaleField;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="keywords", type="text", nullable=true, unique=false)
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
     *      minMessage = "STarget id can not be less than {{ limit }}%.",
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
     * PortalSeo constructor
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
     * Add translations
     *
     * @param SeoTranslation $translation
     * @return self
     */
    public function addTranslation(SeoTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param SeoTranslation $translation
     * @return void
     */
    public function removeTranslation(SeoTranslation $translation): void
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
