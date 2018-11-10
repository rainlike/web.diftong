<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

use App\Entity\TopicSeo;

/**
 * Class TopicSeoTranslation
 *
 * @package App\Entity\Translation
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Entity
 * @ORM\Table(name="app_topic_seo_translation",
 *     indexes={
 *         @ORM\Index(name="topic_seo_translation_index", columns={
 *             "locale", "topic_seo", "field"
 *         })
 *     }
 * )
 */
class TopicSeoTranslation extends AbstractPersonalTranslation
{
    /**
     * @var TopicSeo
     * @ORM\ManyToOne(targetEntity="App\Entity\TopicSeo", inversedBy="translations")
     * @ORM\JoinColumn(name="topic_seo", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $object;

    /**
     * TopicSeoTranslation constructor
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
