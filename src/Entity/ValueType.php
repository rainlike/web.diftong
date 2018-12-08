<?php
/**
 * ValueType Entity
 * Describes model of value type for settings
 *
 * @package App\Entity
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\IBasic;
use App\Entity\Library\Interfaces\ITranslatable;

use App\Entity\Library\Traits\Name\RequiredUnique as NameField;
use App\Entity\Library\Traits\Locale\Translatable as LocaleField;
use App\Entity\Library\Traits\Title\TranslatableRequiredUnique as TitleField;

use App\Entity\Library\Traits\Translations as TranslationMethods;

/**
 * Class ValueType
 *
 * @ORM\Table(name="app_value_type")
 * @ORM\Entity(repositoryClass="App\Repository\ValueTypeRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translations\ValueTypeTranslation")
 * @ORM\HasLifecycleCallbacks()
 */
class ValueType extends BasicEntity implements Translatable, IBasic, ITranslatable
{
    use NameField;
    use TitleField;
    use LocaleField;

    use TranslationMethods;

    /**
     * Possible types
     * @var array
     */
    public const TYPES = [
        self::TYPE_BOOL,
        self::TYPE_INT,
        self::TYPE_FLOAT,
        self::TYPE_DECIMAL,
        self::TYPE_STRING,
        self::TYPE_ARRAY,
        self::TYPE_DATE
    ];

    /**
     * Constants of possible types
     * @var string
     */
    public const TYPE_BOOL = 'bool';
    public const TYPE_INT = 'int';
    public const TYPE_FLOAT = 'float';
    public const TYPE_DECIMAL = 'decimal';
    public const TYPE_STRING = 'string';
    public const TYPE_ARRAY = 'array';
    public const TYPE_DATE = 'date';

    /**
     * Possible regions
     * @var array
     */
    public const REGIONS = [
        self::REGION_GLOBAL,
        self::REGION_HOMEPAGE,
        self::REGION_DEBUG,
        self::REGION_OTHER
    ];

    /**
     * Constants of possible regions
     * @var string
     */
    public const REGION_GLOBAL = 'global';
    public const REGION_HOMEPAGE = 'homepage';
    public const REGION_DEBUG = 'debug';
    public const REGION_OTHER = 'other';

    /**
     * Possible priorities
     * @var array
     */
    public const PRIORITIES = [
        self::PRIORITY_SITE,
        self::PRIORITY_USER
    ];

    /**
     * Constants of possible priorities
     * @var string
     */
    public const PRIORITY_SITE = 'site';
    public const PRIORITY_USER = 'user';

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=25, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="Type should not be blank."
     * )
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "Type must be no longer than {{ limit }} characters."
     * )
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="region", type="string", length=25, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "Region must be no longer than {{ limit }} characters."
     * )
     */
    private $region;

    /**
     * @var string
     * @ORM\Column(name="priority", type="string", length=25, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "Priority must be no longer than {{ limit }} characters."
     * )
     */
    private $priority;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SiteSetting", mappedBy="type", fetch="LAZY")
     */
    private $site_settings;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserSetting", mappedBy="type", fetch="LAZY")
     */
    private $user_settings;

    /**
     * ValueType constructor
     */
    public function __construct()
    {
        $this->site_settings = new ArrayCollection();
        $this->user_settings = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set type
     *
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set region
     *
     * @param string|null $region
     * @return self
     */
    public function setRegion(?string $region = null): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * Set priority
     *
     * @param string|null $priority
     * @return self
     */
    public function setPriority(?string $priority = null): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string|null
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }

    /**
     * Add site_setting
     *
     * @param SiteSetting $setting
     * @return self
     */
    public function addSiteSetting(SiteSetting $setting): self
    {
        $this->site_settings[] = $setting;

        return $this;
    }

    /**
     * Remove site_setting
     *
     * @param SiteSetting $setting
     * @return void
     */
    public function removeSiteSetting(SiteSetting $setting): void
    {
        $this->site_settings->removeElement($setting);
    }

    /**
     * Get site_settings
     *
     * @return ArrayCollection|null
     */
    public function getSiteSettings(): ?ArrayCollection
    {
        return $this->site_settings;
    }

    /**
     * Add user_setting
     *
     * @param UserSetting $setting
     * @return self
     */
    public function addUserSetting(UserSetting $setting): self
    {
        $this->user_settings[] = $setting;

        return $this;
    }

    /**
     * Remove user_setting
     *
     * @param UserSetting $setting
     * @return void
     */
    public function removeUserSetting(UserSetting $setting): void
    {
        $this->user_settings->removeElement($setting);
    }

    /**
     * Get user_settings
     *
     * @return ArrayCollection|null
     */
    public function getUserSettings(): ?ArrayCollection
    {
        return $this->user_settings;
    }
}