<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

use App\Entity\TheorySeo;

/**
 * Class TheorySeoTranslation
 *
 * @package App\Entity\Translation
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Entity
 * @ORM\Table(name="app_theory_seo_translation",
 *     indexes={
 *         @ORM\Index(name="theory_seo_translation_index", columns={
 *             "locale", "theory_seo", "field"
 *         })
 *     }
 * )
 */
class TheorySeoTranslation extends AbstractPersonalTranslation
{
    /**
     * @var TheorySeo
     * @ORM\ManyToOne(targetEntity="App\Entity\TheorySeo", inversedBy="translations")
     * @ORM\JoinColumn(name="theory_seo", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $object;

    /**
     * TheorySeoTranslation constructor
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
