<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

use App\Entity\Portal;

use App\Entity\Library\Interfaces\ITranslation;

/**
 * Class PortalTranslation
 *
 * @package App\Entity\Translation
 * @author Alexander Saveliev <me@rainlike.com>
 * @ORM\Entity
 * @ORM\Table(name="app_portal_translation",
 *     indexes={
 *         @ORM\Index(name="portal_translation_index", columns={
 *             "locale", "portal", "field"
 *         })
 *     }
 * )
 */
class PortalTranslation extends AbstractPersonalTranslation implements ITranslation
{
    /**
     * @var Portal
     * @ORM\ManyToOne(targetEntity="App\Entity\Portal", inversedBy="translations")
     * @ORM\JoinColumn(name="portal", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $object;

    /**
     * PortalTranslation constructor
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
