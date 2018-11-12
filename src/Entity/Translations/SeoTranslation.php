<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

use App\Entity\Seo;

use App\Entity\Library\Interfaces\ITranslation;

/**
 * Class SeoTranslation
 *
 * @package App\Entity\Translation
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Entity
 * @ORM\Table(name="app_seo_translation",
 *     indexes={
 *         @ORM\Index(name="seo_translation_index", columns={
 *             "locale", "seo", "field"
 *         })
 *     }
 * )
 */
class SeoTranslation extends AbstractPersonalTranslation implements ITranslation
{
    /**
     * @var Seo
     * @ORM\ManyToOne(targetEntity="App\Entity\Seo", inversedBy="translations")
     * @ORM\JoinColumn(name="seo", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $object;

    /**
     * SeoTranslation constructor
     *
     * @param string|null $locale
     * @param string|null $field
     * @param string|null $content
     */
    public function __construct(
        ?string $locale = null,
        ?string $field = null,
        ?string $content = null
    ) {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($content);
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }
}
