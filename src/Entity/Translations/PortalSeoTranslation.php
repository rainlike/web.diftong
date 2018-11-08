<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

use App\Entity\PortalSeo;

/**
 * Class PortalSeoTranslation
 *
 * @package App\Entity\Translation
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Entity
 * @ORM\Table(name="app_portal_seo_translation",
 *     indexes={
 *         @ORM\Index(name="portal_seo_translation_index", columns={
 *             "locale", "portal_seo", "field"
 *         })
 *     }
 * )
 */
class PortalSeoTranslation extends AbstractPersonalTranslation
{
    /**
     * @var PortalSeo
     * @ORM\ManyToOne(targetEntity="App\Entity\PortalSeo", inversedBy="translations")
     * @ORM\JoinColumn(name="portal_seo", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $object;

    /**
     * PortalSeoTranslation constructor
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
