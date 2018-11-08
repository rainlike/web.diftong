<?php
declare(strict_types=1);

namespace App\Entity\Library;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\Library\Interfaces\Seoful;
use App\Entity\Library\Interfaces\Seo as SeoInterface;

use App\Entity\Library\Traits\Created as CreatedField;
use App\Entity\Library\Traits\Updated as UpdatedField;
use App\Entity\Library\Traits\Enabled as EnabledField;
use App\Entity\Library\Traits\Locale\Translatable as LocaleField;
use App\Entity\Library\Traits\Title\TranslatableNonRequired as TitleField;
use App\Entity\Library\Traits\Description\TranslatableNonRequired as DescriptionField;

/**
 * Class Seo
 *
 * @package App\Entity\Library
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\MappedSuperclass()
 */
abstract class Seo implements SeoInterface, Translatable
{
    use TitleField;
    use DescriptionField;
    use EnabledField;
    use CreatedField;
    use UpdatedField;
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
     * Set target
     *
     * @param Seoful $target
     * @return self|mixed
     */
    abstract public function setTarget(Seoful $target);

    /**
     * Set target
     *
     * @return mixed|null
     */
    abstract public function getTarget();

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
}
