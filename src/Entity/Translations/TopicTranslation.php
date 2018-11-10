<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

use App\Entity\Topic;

/**
 * Class TopicTranslation
 *
 * @package App\Entity\Translation
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Entity
 * @ORM\Table(name="app_topic_translation",
 *     indexes={
 *         @ORM\Index(name="topic_translation_index", columns={
 *             "locale", "topic", "field"
 *         })
 *     }
 * )
 */
class TopicTranslation extends AbstractPersonalTranslation
{
    /**
     * @var Topic
     * @ORM\ManyToOne(targetEntity="App\Entity\Topic", inversedBy="translations")
     * @ORM\JoinColumn(name="topic", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $object;

    /**
     * TopicTranslation constructor
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
