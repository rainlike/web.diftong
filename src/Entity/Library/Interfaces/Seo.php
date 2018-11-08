<?php
declare(strict_types=1);

namespace App\Entity\Library\Interfaces;

/**
 * Interface Seo
 *
 * @package App\Entity\Library\Interfaces
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
interface Seo
{
    /**
     * Set target
     *
     * @param Seoful $target
     * @return self|mixed
     */
    public function setTarget(Seoful $target);

    /**
     * Set target
     *
     * @return mixed|null
     */
    public function getTarget();

    /**
     * Set title
     *
     * @param string|null $title
     * @return self|mixed
     */
    public function setTitle(?string $title = null);

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Set description
     *
     * @param string|null $description
     * @return self|mixed
     */
    public function setDescription(?string $description = null);

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Set keywords
     *
     * @param string|null $keywords
     * @return self|mixed
     */
    public function setKeywords(?string $keywords = null);

    /**
     * Get keywords
     *
     * @return string|null
     */
    public function getKeywords(): ?string;

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return self|mixed
     */
    public function setCreated(\DateTime $created);

    /**
     * Get created
     *
     * @return \DateTime|null
     */
    public function getCreated(): ?\DateTime;

    /**
     * Set updated
     *
     * @param \DateTime $created
     * @return self|mixed
     */
    public function setUpdated(\DateTime $created);

    /**
     * Get updated
     *
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime;

    /**
     * Set enabled
     *
     * @param bool $enabled
     * @return self|mixed
     */
    public function setEnabled(bool $enabled = true);

    /**
     * Get enabled
     *
     * @return bool|null
     */
    public function getEnabled(): ?bool;

    /**
     * Set translatable locale
     *
     * @param $locale
     * @return self|mixed
     */
    public function setTranslatableLocale($locale);
}
