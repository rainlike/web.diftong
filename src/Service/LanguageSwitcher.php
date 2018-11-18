<?php
/**
 * Language Switcher
 * Generate switcher between site languages
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

use Symfony\Component\Translation\Exception\InvalidArgumentException;

use Symfony\Component\Routing\RouterInterface as Router;
use Symfony\Component\Translation\TranslatorInterface as Translator;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface as EntityManager;

use App\Utility\StaticLibrary;

use App\Entity\Language;

/** Class LanguageSwitcher */
class LanguageSwitcher
{
    /** @var EntityManager */
    private $em;

    /** @var Translator */
    private $translator;

    /** @var Router */
    private $router;

    /** @var Request */
    private $request;

    /**
     * Request variables
     */
    /** @var string */
    private $route;
    /** @var string */
    private $locale;
    /** @var array */
    private $route_parameters;
    /** @var array */
    private $query_parameters;

    /**
     * Short mode
     * @var bool
     */
    private $short_mode = false;

    /**
     * Capitalize mode
     * @var bool
     */
    private $capitalize_mode = false;

    /**
     * LanguageSwitcher constructor
     *
     * @param EntityManager $em
     * @param Translator $translator
     * @param Router $router
     */
    public function __construct(
        EntityManager $em,
        Translator $translator,
        Router $router
    ) {
        $this->em = $em;
        $this->translator = $translator;
        $this->router = $router;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return self
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return self
     */
    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Set routeParameters
     *
     * @param array $routeParameters
     * @return self
     */
    public function setRouteParameters(array $routeParameters): self
    {
        $this->route_parameters = $routeParameters;

        return $this;
    }

    /**
     * Set query_parameters
     *
     * @param array $queryParameters
     * @return self
     */
    public function setQueryParameters(array $queryParameters): self
    {
        $this->query_parameters = $queryParameters;

        return $this;
    }

    /**
     * Set short mod
     *
     * @param bool $mode
     * @return self
     */
    public function setShortMode(bool $mode = true): self
    {
        $this->short_mode = $mode;

        return $this;
    }

    /**
     * Set capitalize mod
     *
     * @param bool $mode
     * @return self
     */
    public function setCapitalizeMode(bool $mode = true): self
    {
        $this->capitalize_mode = $mode;

        return $this;
    }

    /**
     * Initialization and set Request
     *
     * @param Request $request
     * @return self
     */
    public function init(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get switcher
     *
     * @param bool $all
     * @return array
     * @throws RouteNotFoundException
     * @throws MissingMandatoryParametersException
     * @throws InvalidParameterException|InvalidArgumentException
     */
    public function getSwitcher(bool $all = false): array
    {
        $switcher = [];

        $locale = $this->locale ?: $this->request->getLocale();
        $route = $this->route ?: $this->request->get('_route');
        $routeParameters = $this->route_parameters ?: $this->request->get('_route_params');
        $queryParameters = $this->query_parameters ?: [];

        $existingLocales = $this->em->getRepository(Language::class)->getEnabledLocales();
        $return = [];

        foreach ($existingLocales as $existingLocale) {
            $transLocale = $this->short_mode
                ? 'language.short.native.'.$existingLocale
                : 'language.native.'.$existingLocale;

            if ($all || (!$all && ($existingLocale !== $locale))) {
                $extraParameters = \array_merge($routeParameters, $queryParameters);
                $link = $this->router->generate($route, \array_merge($extraParameters, ['_locale' => $existingLocale]));

                $return[] = [
                    'name' => $this->translator->trans($transLocale),
                    'link' => $link
                ];
            }
        }

        if ($this->capitalize_mode) {
            foreach ($return as $key => $item) {
                $name = $item['name'];
                $return[$key]['name'] = StaticLibrary::upFirstChar($name);
            }
        }

        $switcher['items'] = $return;

        return $switcher;
    }
}
