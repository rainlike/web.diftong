<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\Interfaces\Seoful;

use App\Entity\Translations\TopicSeoTranslation;

use App\Entity\Library\Seo;

/**
 * Class TopicSeo
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_topic_seo")
 * @ORM\Entity(repositoryClass="App\Repository\TopicSeoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TopicSeo extends Seo
{
    /**
     * @var Topic
     * @ORM\OneToOne(targetEntity="Topic", inversedBy="seo")
     * @ORM\JoinColumn(name="target", referencedColumnName="id")
     */
    private $target;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Translations\TopicSeoTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * TopicSeo constructor
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set target
     *
     * @param Seoful $target
     * @return self
     */
    public function setTarget(Seoful $target): self
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Set target
     *
     * @return Topic|null
     */
    public function getTarget(): ?Topic
    {
        return $this->target;
    }

    /**
     * Add translations
     *
     * @param TopicSeoTranslation $translation
     * @return self
     */
    public function addTranslation(TopicSeoTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param TopicSeoTranslation $translation
     * @return void
     */
    public function removeTranslation(TopicSeoTranslation $translation): void
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Get translations
     *
     * @return ArrayCollection|null
     */
    public function getTranslations(): ?ArrayCollection
    {
        return $this->translations;
    }
}
