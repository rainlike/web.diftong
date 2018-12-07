<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

use App\Entity\ValueType;

use App\Entity\Library\Interfaces\ITranslation;

/**
 * Class ValueTypeTranslation
 *
 * @package App\Entity\Translation
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Entity
 * @ORM\Table(name="app_value_type_translation",
 *     indexes={
 *         @ORM\Index(name="value_type_translation_index", columns={
 *             "locale", "value_type", "field"
 *         })
 *     }
 * )
 */
class ValueTypeTranslation extends AbstractPersonalTranslation implements ITranslation
{
    /**
     * @var ValueType
     * @ORM\ManyToOne(targetEntity="App\Entity\ValueType", inversedBy="translations")
     * @ORM\JoinColumn(name="value_type", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $object;

    /**
     * ValueTypeTranslation constructor
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
