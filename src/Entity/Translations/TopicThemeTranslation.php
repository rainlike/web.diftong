<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

use App\Entity\TopicTheme;

use App\Entity\Library\Interfaces\ITranslation;

/**
 * Class TopicThemeTranslation
 *
 * @package App\Entity\Translation
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Entity
 * @ORM\Table(name="app_topic_theme_translation",
 *     indexes={
 *         @ORM\Index(name="topic_theme_translation_index", columns={
 *             "locale", "topic_theme", "field"
 *         })
 *     }
 * )
 */
class TopicThemeTranslation extends AbstractPersonalTranslation implements ITranslation
{
    /**
     * @var TopicTheme
     * @ORM\ManyToOne(targetEntity="App\Entity\TopicTheme", inversedBy="translations")
     * @ORM\JoinColumn(name="topic_theme", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $object;

    /**
     * TopicThemeTranslation constructor
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
