<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Translation\TranslatorInterface as Translator;

use App\Utility\StaticLibrary;

/**
 * Class CommonController
 *
 * @package App\Controller
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
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
     * @param string $route
     * @param array $routeParams
     * @param string $url
     * @return Response
     */
    public function renderHeader(
        Request $request,
        string $route,
        array $routeParams,
        string $url
    ): Response
    {
        # @TODO: check if null
        $user = $this->getUser();

        # @TODO: $backLink -> check if it's own link
//        $selfContainer = $this->get('app.self.container');
//        $prevUrl = $selfContainer->previousUrl();
        $backLink = null;

        $queryParameters = StaticLibrary::cutUrlQueryParameters($url);
        $langSwitcher = $this->get('app.lang.switcher')
            ->init($request)
            ->setRoute($route)
            ->setRouteParameters($routeParams)
            ->setQueryParameters($queryParameters)
            ->getSwitcher();

        return $this->render('front/regions/header.html.twig', [
            'user' => $user,
            'language_switcher' => $langSwitcher,
            'back_link' => $backLink
        ]);
    }

    /**
     * Render footer
     *
     * @param Request $request
     * @param Translator $translator
     * @param string $route
     * @param array $routeParams
     * @param string $url
     * @return Response
     */
    public function renderFooter(
        Request $request,
        Translator $translator,
        string $route,
        array $routeParams,
        string $url
    ): Response
    {
        # @TODO: check if null
        $user = $this->getUser();

        # @TODO: $footerItems

        $queryParameters = StaticLibrary::cutUrlQueryParameters($url);
        $langSwitcher = $this->get('app.lang.switcher')
            ->init($request)
            ->setRoute($route)
            ->setRouteParameters($routeParams)
            ->setQueryParameters($queryParameters)
            ->getSwitcher();

        return $this->render('front/regions/footer.html.twig', [
            'user' => $user,
            'language_switcher' => $langSwitcher
        ]);
    }
}
