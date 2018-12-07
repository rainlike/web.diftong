<?php
/**
 * Seo Service
 * Provides methods for generate and extract SEO data
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Translation\TranslatorInterface as Translator;

use Doctrine\ORM\EntityManagerInterface as EntityManager;

use App\Entity\Library\Interfaces\ISeoable;

use App\Entity\Seo as SeoEntity;

/** Class Seo */
class Seo
{
    /** @var EntityManager */
    private $em;

    /** @var Translator */
    private $translator;

    /** @var ISeoable */
    private $target;

    /**
     * Domain
     * @var string
     */
    private $domain;

    /**
     * Site name
     * @var string
     */
    private $site_name;

    /**
     * Default title
     * @var string
     */
    private $title;

    /**
     * Default description
     * @var string
     */
    private $description;

    /**
     * Default keywords
     * @var string
     */
    private $keywords;

    /**
     * Seo constructor
     *
     * @param EntityManager $em
     * @param Translator $translator
     * @param string $domain
     * @param string $siteName
     */
    public function __construct(
        EntityManager $em,
        Translator $translator,
        string $domain,
        string $siteName
    ) {
        $this->em = $em;
        $this->translator = $translator;

        $this->domain = $domain;
        $this->site_name = $siteName;

        $this->title = $this->translator->trans('title', [], 'seo');
        $this->description = $this->translator->trans('description', [], 'seo');
        $this->keywords = $this->translator->trans('keywords', [], 'seo');
    }

    /**
     * Set initial target
     *
     * @param ISeoable $target
     * @return self
     */
    public function init(ISeoable $target): self
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get Seoable entity
     *
     * @param ISeoable|null $target
     * @return ISeoable
     */
    public function getSeoObject(ISeoable $target = null): ISeoable {}

    /**
     * Set Seoable entity
     *
     * @param SeoEntity|null $seoEntity
     * @param ISeoable|null $target
     * @return self
     */
    public function setSeoObject(SeoEntity $seoEntity = null, ISeoable $target = null): self {}

    /**
     * Get SEO attributes
     *
     * @param ISeoable|null $target
     * @return array
     */
    public function getSeo(ISeoable $target = null): array {}

    /**
     * Get text for logo attributes
     *
     * @return string
     */
    public function getLogoText()
    {
        return $this->translator->trans('logo_text', [], 'seo');
    }

    /**
     * Calculate SEO attributes
     *
     * @param ISeoable|null $target
     * @return array
     */
    private function calculateSeo(ISeoable $target = null): array {}
}
