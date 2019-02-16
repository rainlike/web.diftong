<?php
/**
 * Seo Service
 * Provides methods for generate and extract SEO data
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 diftong.com (https://www.diftong.com)
 * @author Alexander Saveliev <me@rainlike.com>
 */
declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface as Translator;

use Doctrine\ORM\EntityManagerInterface as EntityManager;

use App\Entity\Library\Interfaces\ISeoable;

use App\Entity\Seo as SeoEntity;

use App\Controller\PortalController;
use App\Controller\TheoryController;

use App\Entity\Portal;
use App\Entity\Theory;

/** Class Seo */
class Seo
{
    /** @var Request */
    private $request;

    /** @var EntityManager */
    private $em;

    /** @var Translator */
    private $translator;

    /** @var AnnotationReader */
    private $annotation_reader;

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
     * @param RequestStack $requestStack
     * @param EntityManager $em
     * @param Translator $translator
     * @param AnnotationReader $annotation_reader
     * @param string $domain
     * @param string $siteName
     */
    public function __construct(
        RequestStack $requestStack,
        EntityManager $em,
        Translator $translator,
        AnnotationReader $annotation_reader,
        string $domain,
        string $siteName
    ) {
        $this->request = $requestStack->getCurrentRequest();

        $this->em = $em;
        $this->translator = $translator;
        $this->annotation_reader = $annotation_reader;

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
    public function getLogoText(): string
    {
        return $this->translator->trans('logo_text', [], 'seo');
    }

    /**
     * Get SEO text for footer
     *
     * @return string
     * @throws NonUniqueResultException
     */
    public function getFooterSeo(): string
    {
        $defaultSeo = $this->translator->trans('description', [], 'seo');
        $targetRouteName = $this->request->get('_route');

        $showActionRouteName = function ($controller) {
            return $this->annotation_reader->getMethodAnnotation(
                Route::class,
                'show',
                $controller
            )->getName();
        };

        $routeParams = $this->request->get('_route_params');
        if (\array_key_exists('_locale', $routeParams)) {
            unset($routeParams['_locale']);
        }

        switch ($targetRouteName) {
            case $showActionRouteName(TheoryController::class):
                if (!\array_key_exists('uri', $routeParams) || !\array_key_exists('portal_uri', $routeParams)) {
                    return $defaultSeo;
                }

                $theory = $this->em->getRepository(Theory::class)->findByUltimateUri(
                    $routeParams['uri'],
                    true,
                    $routeParams['portal_uri']
                );

                return $theory ? $theory->getCaption() : $defaultSeo;

                break;
            case $showActionRouteName(PortalController::class):
                if (!\array_key_exists('uri', $routeParams)) {
                    return $defaultSeo;
                }

                $portal = $this->em->getRepository(Portal::class)->findByUltimateUri(
                    $routeParams['uri'],
                    true
                );

                return $portal ? $portal->getCaption() : $defaultSeo;

                break;
        }

        return $defaultSeo;
    }


    /**
     * Calculate SEO attributes
     *
     * @param ISeoable|null $target
     * @return array
     */
    private function calculateSeo(ISeoable $target = null): array {}
}
