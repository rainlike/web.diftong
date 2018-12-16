<?php
/**
 * Common Controller
 * Controller which provides functionality for header and footer
 *
 * @package App\Controller
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Translation\TranslatorInterface as Translator;

use App\Entity\Quote
    ;
use App\Service\Library;
use App\Service\Logotype;
use App\Service\LanguageSwitcher;

/** Class CommonController */
class CommonController extends Controller
{
    /**
     * Redirect URLs with a trailing slash
     *
     * @param Request $request
     * @return RedirectResponse
     * @Route("/{url}",
     *         methods={"GET"},
     *         name="remove_trailing_slash",
     *         requirements={"url" = ".*\/$"}
     * )
     */
    public function removeTrailingSlash(Request $request): RedirectResponse
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = \str_replace($pathInfo, \rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url, 301);
    }

    /**
     * Render header
     *
     * @param Request $request
     * @param Translator $translator
     * @param string $route
     * @param array $routeParams
     * @param string $url
     * @param Library $library
     * @param LanguageSwitcher $languageSwitcher
     * @param Logotype $logotype
     * @return Response
     */
    public function renderHeader(
        Request $request,
        Translator $translator,
        string $route,
        array $routeParams,
        string $url,
        Library $library,
        LanguageSwitcher $languageSwitcher,
        Logotype $logotype
    ): Response
    {
        $user = $this->getUser();

        # @TODO: menu
        # @TODO: $backLink -> check if it's own link
//        $selfContainer = $this->get('app.self.container');
//        $prevUrl = $selfContainer->previousUrl();
        $backLink = null;

        $queryParameters = $library->cutUrlQueryParameters($url);
        $langSwitcher = $languageSwitcher
            ->init($request)
            ->setRoute($route)
            ->setRouteParameters($routeParams)
            ->setQueryParameters($queryParameters)
            ->getSwitcher();

        $logo = $logotype->getVerboseLogo();

        return $this->render('regions/header.html.twig', [
            'user' => $user,
            'logo' => $logo,
            'language_switcher' => $langSwitcher,
            'back_link' => $backLink
        ]);
    }

    /**
     * Render menu
     *
     * @param Translator $translator
     * @param Library $library
     * @return Response
     */
    public function renderMenu(
        Translator $translator,
        Library $library
    ): Response
    {
        return $this->render('components/menu.html.twig', []);
    }

    /**
     * Render sidebar
     *
     * @param Translator $translator
     * @param Library $library
     * @return Response
     */
    public function renderSidebar(
        Translator $translator,
        Library $library
    ): Response
    {
        return $this->render('regions/sidebar.html.twig', []);
    }

    /**
     * Render footer
     *
     * @param Request $request
     * @param Translator $translator
     * @param string $route
     * @param array $routeParams
     * @param string $url
     * @param Library $library
     * @param LanguageSwitcher $languageSwitcher
     * @param Logotype $logotype
     * @return Response
     */
    public function renderFooter(
        Request $request,
        Translator $translator,
        string $route,
        array $routeParams,
        string $url,
        Library $library,
        LanguageSwitcher $languageSwitcher,
        Logotype $logotype
    ): Response
    {
        $user = $this->getUser();

        # @TODO: $footerItems

        $queryParameters = $library->cutUrlQueryParameters($url);
        $langSwitcher = $languageSwitcher
            ->init($request)
            ->setRoute($route)
            ->setRouteParameters($routeParams)
            ->setQueryParameters($queryParameters)
            ->getSwitcher();

        $logo = $logotype->getSketch();

        return $this->render('regions/footer.html.twig', [
            'user' => $user,
            'logo' => $logo,
            'language_switcher' => $langSwitcher
        ]);
    }
}
