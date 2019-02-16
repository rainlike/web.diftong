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

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface as Translator;

use App\Entity\Quote;
use App\Entity\Topic;

use App\Service\Menu;
use App\Service\Library;
use App\Service\Logotype;
use App\Service\Seo as SeoSrv;
use App\Service\LanguageSwitcher;
use App\Service\Socials as SocialsSrv;

/** Class CommonController */
class CommonController extends AbstractController
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
        string $route,
        array $routeParams,
        string $url,
        Library $library,
        LanguageSwitcher $languageSwitcher,
        Logotype $logotype
    ): Response
    {
        $user = $this->getUser();

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
     * @param Request $request
     * @param Menu $menuSrv
     * @return Response
     * @throws NonUniqueResultException
     */
    public function renderMenu(
        Request $request,
        Menu $menuSrv
    ): Response
    {
        $menu = $menuSrv
            ->init($request)
            ->setBackLinkMod()
            ->getMenu();

        return $this->render('components/menu.html.twig', [
            'menu' => $menu
        ]);
    }

    /**
     * Render sidebar
     *
     * @return Response
     * @throws NonUniqueResultException
     */
    public function renderSidebar(): Response
    {
        $topicsCount = $this->getParameter('sidebar.topics.count');

        $quote = $this->getDoctrine()->getRepository(Quote::class)->getRandom();
        $topics = $this->getDoctrine()->getRepository(Topic::class)->getLasts($topicsCount);

        return $this->render('regions/sidebar.html.twig', [
            'quote' => $quote,
            'topics' => $topics
        ]);
    }

    /**
     * Render footer
     *
     * @param Request $request
     * @param string $route
     * @param array $routeParams
     * @param string $url
     * @param Library $library
     * @param LanguageSwitcher $languageSwitcher
     * @param Logotype $logotype
     * @param SeoSrv $seoSrv
     * @param SocialsSrv $socialsSrv
     * @return Response
     * @throws NonUniqueResultException
     */
    public function renderFooter(
        Request $request,
        string $route,
        array $routeParams,
        string $url,
        Library $library,
        LanguageSwitcher $languageSwitcher,
        Logotype $logotype,
        SeoSrv $seoSrv,
        SocialsSrv $socialsSrv
    ): Response
    {
        $user = $this->getUser();

        $queryParameters = $library->cutUrlQueryParameters($url);
        $langSwitcher = $languageSwitcher
            ->init($request)
            ->setRoute($route)
            ->setRouteParameters($routeParams)
            ->setQueryParameters($queryParameters)
            ->getSwitcher();

        $logo = $logotype->getSketch();
        $seo = $seoSrv->getFooterSeo();
        $socials = $socialsSrv->getFooterItems();

        return $this->render('regions/footer.html.twig', [
            'user' => $user,
            'logo' => $logo,
            'seo' => $seo,
            'socials' => $socials,
            'language_switcher' => $langSwitcher
        ]);
    }
}
