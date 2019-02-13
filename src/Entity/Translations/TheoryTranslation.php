<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

use App\Entity\Theory;

use App\Entity\Library\Interfaces\ITranslation;

/**
 * Class TheoryTranslation
 *
 * @package App\Entity\Translation
 * @author Alexander Saveliev <me@rainlike.com>
 * @ORM\Entity
 * @ORM\Table(name="app_theory_translation",
 *     indexes={
 *         @ORM\Index(name="theory_translation_index", columns={
 *             "locale", "theory", "field"
 *         })
 *     }
 * )
 */
class TheoryTranslation extends AbstractPersonalTranslation implements ITranslation
{
    /**
     * @var Theory
     * @ORM\ManyToOne(targetEntity="App\Entity\Theory", inversedBy="translations")
     * @ORM\JoinColumn(name="theory", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $object;

    /**
     * TheoryTranslation constructor
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
